<!DOCTYPE html>
<html lang="en">

<body>
  <script src="./js/go.js"></script>
  <!--<p>
    Ready to Design your family tree Program ?<br>
    Unfortunately, you won't be able to add wifes or daughter in laws.
  </p> -->
  <div id="allSampleContent" class="p-4 w-full">

    <link rel="stylesheet" href="./DataInspector.css">
    <script src="./DataInspector.js"></script>
    <script src="./js/jquery_min.js"></script>
    <script type="text/javascript" src="./js/ajax.js"></script>

    <script id="code">
      function init() {

        // Since 2.2 you can also author concise templates with method chaining instead of GraphObject.make
        // For details, see https://gojs.net/latest/intro/buildingObjects.html
        const $ = go.GraphObject.make; // for conciseness in defining templates

        myDiagram =
          $(go.Diagram, "myDiagramDiv", // must be the ID or reference to div
            {
              allowCopy: false,
              allowDelete: true,
              //initialAutoScale: go.Diagram.Uniform,
              maxSelectionCount: 1, // users can select only one part at a time
              validCycle: go.Diagram.CycleDestinationTree, // make sure users can only create trees
              "clickCreatingTool.archetypeNodeData": { // allow double-click in background to create a new node
                name: "(Nouvelle Personne)",
                title: "set title",
                comments: "comment",
                mother: "mother",
                spouse: "spouse",
                pic: ""
              },
              "clickCreatingTool.insertPart": function(loc) { // override to scroll to the new node
                const node = go.ClickCreatingTool.prototype.insertPart.call(this, loc);
                if (node !== null) {
                  this.diagram.select(node);
                  this.diagram.commandHandler.scrollToPart(node);
                  this.diagram.commandHandler.editTextBlock(node.findObject("NAMETB"));
                }
                return node;
              },
              layout: $(go.TreeLayout, {
                treeStyle: go.TreeLayout.StyleLastParents,
                arrangement: go.TreeLayout.ArrangementHorizontal,
                // properties for most of the tree:
                angle: 90,
                layerSpacing: 35,
                // properties for the "last parents":
                alternateAngle: 90,
                alternateLayerSpacing: 35,
                alternateAlignment: go.TreeLayout.AlignmentBus,
                alternateNodeSpacing: 20
              }),
              "undoManager.isEnabled": true // enable undo & redo
            });

        // when the document is modified, add a "*" to the title and enable the "Save" button
        myDiagram.addDiagramListener("Modified", e => {
          const button = document.getElementById("SaveButton");
          if (button) button.disabled = !myDiagram.isModified;
          const idx = document.title.indexOf("*");
          if (myDiagram.isModified) {
            if (idx < 0) document.title += "*";
          } else {
            if (idx >= 0) document.title = document.title.slice(0, idx);
          }
        });

        const levelColors = ["#AC193D", "#2672EC", "#8C0095", "#5133AB",
          "#008299", "#D24726", "#008A00", "#094AB2"
        ];

        // override TreeLayout.commitNodes to also modify the background brush based on the tree depth level
        myDiagram.layout.commitNodes = function() {
          go.TreeLayout.prototype.commitNodes.call(this); // do the standard behavior
          // then go through all of the vertexes and set their corresponding node's Shape.fill
          // to a brush dependent on the TreeVertex.level value
          myDiagram.layout.network.vertexes.each(v => {
            if (v.node) {
              const level = v.level % (levelColors.length);
              const color = levelColors[level];
              const shape = v.node.findObject("SHAPE");
              if (shape) shape.stroke = $(go.Brush, "Linear", {
                0: color,
                1: go.Brush.lightenBy(color, 0.05),
                start: go.Spot.Left,
                end: go.Spot.Right
              });
            }
          });
        };

        // this is used to determine feedback during drags
        function mayWorkFor(node1, node2) {
          if (!(node1 instanceof go.Node)) return false; // must be a Node
          if (node1 === node2) return false; // cannot work for yourself
          if (node2.isInTreeOf(node1)) return false; // cannot work for someone who works for you
          return true;
        }

        // This function provides a common style for most of the TextBlocks.
        // Some of these values may be overridden in a particular TextBlock.
        function textStyle() {
          return {
            font: "9pt  Segoe UI,sans-serif",
            stroke: "white"
          };
        }

        // This converter is used by the Picture.
        function findHeadShot(pic) {
          if (!pic) return "images/nopic.webp"; // There are only 16 images on the server
          return "images/HS" + pic;
        }

        // define the Node template
        myDiagram.nodeTemplate =
          $(go.Node, "Spot", {
              selectionObjectName: "BODY",
              mouseEnter: (e, node) => node.findObject("BUTTON").opacity = node.findObject("BUTTONX").opacity = 1,
              mouseLeave: (e, node) => node.findObject("BUTTON").opacity = node.findObject("BUTTONX").opacity = 0,
              // handle dragging a Node onto a Node to (maybe) change the reporting relationship
              mouseDragEnter: (e, node, prev) => {
                const diagram = node.diagram;
                const selnode = diagram.selection.first();
                if (!mayWorkFor(selnode, node)) return;
                const shape = node.findObject("SHAPE");
                if (shape) {
                  shape._prevFill = shape.fill; // remember the original brush
                  shape.fill = "darkred";
                }
              },
              mouseDragLeave: (e, node, next) => {
                const shape = node.findObject("SHAPE");
                if (shape && shape._prevFill) {
                  shape.fill = shape._prevFill; // restore the original brush
                }
              },
              mouseDrop: (e, node) => {
                const diagram = node.diagram;
                const selnode = diagram.selection.first(); // assume just one Node in selection
                if (mayWorkFor(selnode, node)) {
                  // find any existing link into the selected node
                  const link = selnode.findTreeParentLink();
                  if (link !== null) { // reconnect any existing link
                    link.fromNode = node;
                  } else { // else create a new link
                    diagram.toolManager.linkingTool.insertLink(node, node.port, selnode, selnode.port);
                  }
                }
              }
            },
            // for sorting, have the Node.text be the data.name
            new go.Binding("text", "name"),
            // bind the Part.layerName to control the Node's layer depending on whether it isSelected
            new go.Binding("layerName", "isSelected", sel => sel ? "Foreground" : "").ofObject(),
            $(go.Panel, "Auto", {
                name: "BODY"
              },
              // define the node's outer shape
              $(go.Shape, "Rectangle", {
                name: "SHAPE",
                fill: "#333333",
                stroke: 'white',
                strokeWidth: 3.5,
                portId: ""
              }),
              $(go.Panel, "Horizontal",
                $(go.Picture, {
                    name: "Picture",
                    desiredSize: new go.Size(80, 80),
                    margin: 1.5,
                    source: "images/nopic.webp" // the default image
                  },
                  new go.Binding("source", "pic", findHeadShot)),
                // define the panel where the text will appear
                $(go.Panel, "Table", {
                    minSize: new go.Size(130, NaN),
                    maxSize: new go.Size(150, NaN),
                    margin: new go.Margin(6, 10, 0, 6),
                    defaultAlignment: go.Spot.Left
                  },
                  $(go.RowColumnDefinition, {
                    column: 2,
                    width: 4
                  }),
                  $(go.TextBlock, textStyle(), // the name
                    {
                      name: "NAMETB",
                      row: 0,
                      column: 0,
                      columnSpan: 5,
                      font: "12pt Segoe UI,sans-serif",
                      editable: true,
                      isMultiline: false,
                      minSize: new go.Size(50, 16)
                    },
                    new go.Binding("text", "name").makeTwoWay()),
                  $(go.TextBlock, "Title: ", textStyle(), {
                    row: 1,
                    column: 0
                  }),
                  $(go.TextBlock, textStyle(), {
                      row: 1,
                      column: 1,
                      columnSpan: 4,
                      editable: true,
                      isMultiline: false,
                      minSize: new go.Size(50, 14),
                      margin: new go.Margin(0, 0, 0, 3)
                    },
                    new go.Binding("text", "title").makeTwoWay()),
                  $(go.TextBlock, textStyle(), {
                      row: 2,
                      column: 0
                    },
                    new go.Binding("text", "key", v => "ID: " + v)),
                  $(go.TextBlock, textStyle(), // the comments
                    {
                      row: 3,
                      column: 1,
                      columnSpan: 5,
                      font: "italic 9pt sans-serif",
                      wrap: go.TextBlock.WrapFit,
                      editable: true, // by default newlines are allowed
                      minSize: new go.Size(100, 14)
                    },
                    new go.Binding("text", "comments").makeTwoWay()),
                  $(go.TextBlock, "Mother : ", textStyle(), {
                    row: 4,
                    column: 0
                  }),
                  $(go.TextBlock, textStyle(), // mother
                    {
                      row: 4,
                      column: 1,
                      columnSpan: 5,
                      wrap: go.TextBlock.WrapFit,
                      editable: true, // by default newlines are allowed
                      minSize: new go.Size(100, 14)
                    },
                    new go.Binding("text", "mother").makeTwoWay()),
                  $(go.TextBlock, "Spouse : ", textStyle(), {
                    row: 5,
                    column: 0
                  }),
                  $(go.TextBlock, textStyle(), // spouse
                    {
                      row: 5,
                      column: 1,
                      columnSpan: 5,
                      wrap: go.TextBlock.WrapFit,
                      editable: true, // by default newlines are allowed
                      minSize: new go.Size(100, 14)
                    },
                    new go.Binding("text", "spouse").makeTwoWay())

                ) // end Table Panel
              ) // end Horizontal Panel
            ), // end Auto Panel
            $("Button",
              $(go.Shape, "PlusLine", {
                width: 10,
                height: 10
              }), {
                name: "BUTTON",
                alignment: go.Spot.Left,
                opacity: 0, // initially not visible
                click: (e, button) => addEmployee(button.part)
              },
              // button is visible either when node is selected or on mouse-over
              new go.Binding("opacity", "isSelected", s => s ? 1 : 0).ofObject()
            ),
            new go.Binding("isTreeExpanded").makeTwoWay(),
            $("TreeExpanderButton", {
                name: "BUTTONX",
                alignment: go.Spot.Bottom,
                opacity: 0, // initially not visible
                "_treeExpandedFigure": "TriangleUp",
                "_treeCollapsedFigure": "TriangleDown"
              },
              // button is visible either when node is selected or on mouse-over
              new go.Binding("opacity", "isSelected", s => s ? 1 : 0).ofObject()
            )
          ); // end Node, a Spot Panel

        function addEmployee(node) {
          if (!node) return;
          const thisemp = node.data;
          myDiagram.startTransaction("add Children");
          const newemp = {
            name: "(new person)",
            title: "(title)",
            pic: "",
            comments: "comment",
            mother: "mother's name",
            spouse: "spouse's name",
            parent: thisemp.key
          };
          myDiagram.model.addNodeData(newemp);
          const newnode = myDiagram.findNodeForData(newemp);
          if (newnode) newnode.location = node.location;
          myDiagram.commitTransaction("add Children");
          myDiagram.commandHandler.scrollToPart(newnode);
        }

        // the context menu allows users to make a position vacant,
        // remove a role and reassign the subtree, or remove a department
        myDiagram.nodeTemplate.contextMenu =
          $("ContextMenu",
            $("ContextMenuButton",
              $(go.TextBlock, "Add Children"), {
                click: (e, button) => addEmployee(button.part.adornedPart)
              }
            ),
            $("ContextMenuButton",
              $(go.TextBlock, "Clear Infos"), {
                click: (e, button) => {
                  const node = button.part.adornedPart;
                  if (node !== null) {
                    const thisemp = node.data;
                    myDiagram.startTransaction("vacate");
                    // update the key, name, picture, and comments, but leave the title
                    myDiagram.model.setDataProperty(thisemp, "name", "(Vacant)");
                    myDiagram.model.setDataProperty(thisemp, "pic", "");
                    myDiagram.model.setDataProperty(thisemp, "comments", "");
                    myDiagram.model.setDataProperty(thisemp, "mother", "");
                    myDiagram.model.setDataProperty(thisemp, "spouse", "");
                    myDiagram.commitTransaction("vacate");
                  }
                }
              }
            ),
            $("ContextMenuButton",
              $(go.TextBlock, "Remove Member"), {
                click: (e, button) => {
                  // reparent the subtree to this node's boss, then remove the node
                  const node = button.part.adornedPart;
                  if (node !== null) {
                    myDiagram.startTransaction("reparent remove");
                    const chl = node.findTreeChildrenNodes();
                    // iterate through the children and set their parent key to our selected node's parent key
                    while (chl.next()) {
                      const emp = chl.value;
                      myDiagram.model.setParentKeyForNodeData(emp.data, node.findTreeParentNode().data.key);
                    }
                    // and now remove the selected node itself
                    myDiagram.model.removeNodeData(node.data);
                    myDiagram.commitTransaction("reparent remove");
                  }
                }
              }
            ),
            $("ContextMenuButton",
              $(go.TextBlock, "Clear Everything"), {
                click: (e, button) => {
                  // remove the whole subtree, including the node itself
                  const node = button.part.adornedPart;
                  if (node !== null) {
                    myDiagram.startTransaction("remove dept");
                    myDiagram.removeParts(node.findTreeParts());
                    myDiagram.commitTransaction("remove dept");
                  }
                }
              }
            )
          );

        // define the Link template
        myDiagram.linkTemplate =
          $(go.Link, go.Link.Orthogonal, {
              layerName: "Background",
              corner: 5
            },
            $(go.Shape, {
              strokeWidth: 2.0,
              stroke: "#000000"
            })); // the link shape

        // read in the JSON-format data from the "mySavedModel" element
        load();


        // support editing the properties of the selected person in HTML
        if (window.Inspector) myInspector = new Inspector("myInspector", myDiagram, {
          properties: {
            "key": {
              readOnly: true
            },
            "comments": {},
            "pic": {}
          }
        });

        // Setup zoom to fit button
        document.getElementById('zoomToFit').addEventListener('click', () => myDiagram.commandHandler.zoomToFit());

        document.getElementById('centerRoot').addEventListener('click', () => {
          myDiagram.scale = 1;
          myDiagram.commandHandler.scrollToPart(myDiagram.findNodeForKey(1));
        });
      } // end init

      // Show the diagram's model in JSON format
      function save() {

        let trytest = myDiagram.model.toJson();
        let lastletter = ((trytest.length) - 1);
        //alert(trytest.substring(42,lastletter) );
        updateModel(trytest.substring(42, lastletter));
        document.getElementById("mySavedModel").value = myDiagram.model.toJson();
        myDiagram.isModified = false;
      }

      function load() {
        myDiagram.model = go.Model.fromJson(document.getElementById("mySavedModel").value);
        // make sure new data keys are unique positive integers
        let lastkey = 1;
        myDiagram.model.makeUniqueKeyFunction = (model, data) => {
          let k = data.key || lastkey;
          while (model.findNodeDataForKey(k)) k++;
          data.key = lastkey = k;
          return k;
        };
      }

      function updateModel(datas) {
        var datalist = datas;
        <?php
        echo ("var id = " . $_GET["id"] . ";");
        ?>
        $.ajax({
          method: "POST",
          url: "./crud/SetfamilyTree.php",
          data: {
            datalist: datalist,
            id: id
          },
          cache: false,
          success: function(data) {
            $('#msg').html(data);
          }
        });
      }

      window.addEventListener('DOMContentLoaded', init);
    </script>

    <div id="sample">
      <div id="myDiagramDiv" style="  background-image: linear-gradient(to right, #ff5b16, #fc10e7); border: 1px solid black; height: 570px; position: relative; cursor: auto; font: 12pt Segoe UI, sans-serif;">
        <canvas id="myCanvas" tabindex="0" style="position: absolute; top: 0px; left: 0px; z-index: 2; user-select: none; touch-action: none; width: 1054px; height: 551px; cursor: auto;" width="1054" height="551">
        </canvas>
        <div style="position: absolute; overflow: auto; width: 1054px; height: 568px; z-index: 1;">
          <div style="position: absolute; width: 1586.24px; height: 1px;">
          </div>
        </div>
        <textarea style="position: absolute; z-index: 100; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; font-size: 100%; line-height: normal; font-family: inherit; font-size-adjust: inherit; font-kerning: inherit; font-optical-sizing: inherit; font-language-override: inherit; font-feature-settings: inherit; font-variation-settings: inherit; width: 97.5833px; left: 183px; top: 429px; text-align: start; margin: 0px; padding: 1px; border: 0px none; outline: none; white-space: pre-wrap; overflow: hidden;" rows="1" class="goTXarea">
    </textarea>
      </div>
      <div>
        <p id="msg"></p> <br>
        Edit details:<br>
        <div id="myInspector" class="inspector">
          <table>
            <tbody>
              <tr>
                <td>key</td>
                <td><input type="undefined" tabindex="0" disabled=""></td>
              </tr>
              <tr>
                <td>comments</td>
                <td><input type="undefined" tabindex="1"></td>
              </tr>
              <tr>
                <td>name</td>
                <td><input tabindex="2"></td>
              </tr>
              <tr>
                <td>title</td>
                <td><input tabindex="3"></td>
              </tr>
              <tr>
                <td>parent</td>
                <td><input tabindex="4"></td>
              </tr>
              <tr>
                <td>Mother</td>
                <td><input tabindex="5"></td>
              </tr>
              <tr>
                <td>Spouse</td>
                <td><input tabindex="6"></td>
              </tr>
              <tr>
                <td>Picture</td>
                <td><input tabindex="7"></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <p><button id="zoomToFit" class="btn btn-primary btn-xs">Zoom to Fit</button> <button class="btn btn-primary btn-xs" id="centerRoot">Center on root</button></p>

      <div>
        <div>
          <button id="SaveButton" class="btn btn-primary" onclick="save()">Update</button>
          Diagram will be saved in your account. <br>
          <!--<button id="btnPrint" class="btn btn-primary">Print</button>-->
          <div style="border: 1px solid gray; padding: 10px; margin-bottom: 20px;">
            Width: <input id="widthInput" value="700">
            Height: <input id="heightInput" value="960">
            <button id="makeImages" class="btn btn-primary">Generate images for printing</button>
          </div>
          <button onclick="load()" hidden>Load</button>
          <div id="myImages" class="prints">
            <img src="" />
          </div>
        </div>
        <?php
        include_once './database.php';
        $database = new Database();
        $db = $database->getConnection();
        $idD = $_GET["id"];
        $rec = $db->query("SELECT * FROM familly where diagramme =" . $idD)->fetchAll(PDO::FETCH_OBJ);
        $totals = sizeof($rec);
        echo ('    <textarea id="mySavedModel" style="width:100%; height:270px;" hidden>{ "class": "go.TreeModel",
              "nodeDataArray": [');
        $nodesarr = '';
        for ($x = 0; $x < $totals; $x++) {
          if ($x == ($totals - 1)) {
            $nodesarr .= '{"key":"' . $rec[$x]->keyss . '", "name":"' . $rec[$x]->name . '", "title":"' . $rec[$x]->title . '", "pic":"' . $rec[$x]->pic . '", "comments":"' . $rec[$x]->comments . '", "parent":"' . $rec[$x]->parent . '" , "mother":"' . $rec[$x]->mother . '" , "spouse":"' . $rec[$x]->spouse . '"}';
          } else {
            $nodesarr .= '{"key":"' . $rec[$x]->keyss . '", "name":"' . $rec[$x]->name . '", "title":"' . $rec[$x]->title . '", "pic":"' . $rec[$x]->pic . '", "comments":"' . $rec[$x]->comments . '", "parent":"' . $rec[$x]->parent . '" , "mother":"' . $rec[$x]->mother . '" , "spouse":"' . $rec[$x]->spouse . '"},';
          }
        }
        echo ($nodesarr);
        echo (' ]
              }');
        ?>
        </textarea>
      </div>
      <script src="./js/jspdf.min.js"></script>
      <script>
        $(document).ready(function() {
          var form = $('.prints'),
            cache_width = form.width(),
            a4 = [595.28, 841.89]; // for a4 size paper width and height  

          $('#btnPrint').on('click', function() {
            $('myImages').scrollTop(0);
            createPDF();
          });

          function createPDF() {
            getCanvas().then(function(canvas) {
              var
                img = canvas.toDataURL("image/png"),
                doc = new jsPDF({
                  unit: 'px',
                  format: 'a4'
                });
              doc.addImage(img, 'JPEG', 20, 20);
              doc.save('fmt.pdf');
              form.width(cache_width);
            });
          }

          function getCanvas() {
            form.width((a4[0] * 1.33333) - 80).css('max-width', 'none');
            return html2canvas(form, {
              imageTimeout: 2000,
              removeContainer: true
            });
          }

          // if width or height are below 50, they are set to 50
          function generateImages(width, height) {
            // sanitize input
            width = parseInt(width);
            height = parseInt(height);
            if (isNaN(width)) width = 100;
            if (isNaN(height)) height = 100;
            // Give a minimum size of 50x50
            width = Math.max(width, 50);
            height = Math.max(height, 50);

            var imgDiv = document.getElementById('myImages');
            imgDiv.innerHTML = ''; // clear out the old images, if any
            var db = myDiagram.documentBounds;
            var boundswidth = db.width;
            var boundsheight = db.height;
            var imgWidth = width;
            var imgHeight = height;
            var p = db.position;
            for (let i = 0; i < boundsheight; i += imgHeight) {
              for (let j = 0; j < boundswidth; j += imgWidth) {
                var img = myDiagram.makeImage({
                  scale: 1,
                  position: new go.Point(p.x + j, p.y + i),
                  size: new go.Size(imgWidth, imgHeight)
                });
                // Append the new HTMLImageElement to the #myImages div
                img.className = 'images';
                imgDiv.appendChild(img);
                imgDiv.appendChild(document.createElement('br'));
              }
            }
            $('myImages').scrollTop(0);
            createPDF();
          }

          var button = document.getElementById('makeImages');
          button.addEventListener('click', () => {
            var width = parseInt(document.getElementById('widthInput').value);
            var height = parseInt(document.getElementById('heightInput').value);
            generateImages(width, height);
          }, false);

          // Call it with some default values
          //generateImages(700, 960);
        });
      </script>
</body>

</html>