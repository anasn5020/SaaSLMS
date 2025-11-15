<link rel="stylesheet" href="{{asset('public/frontend/infixlmstheme/plugins/drawflow/drawflow.css')}}">

<div id="matchingQus{{$qusBank->id}}" ondrop="drop(event)"
     ondragover="allowDrop(event)"
     style="width: 100%;overflow: auto;height: {{count($qusBank->questionMuInSerial)*80}}px">


</div>
<input type="hidden" value="" name="matching_connection[{{$qusBank->id}}]" id="matching_connection_{{$qusBank->id}}">

<script src="{{asset('public/frontend/infixlmstheme/plugins/drawflow/drawflow.js')}}"></script>


<script>

    let id{{$qusBank->id}} = document.getElementById("matchingQus{{$qusBank->id}}");
    const editor{{$qusBank->id}} = new Drawflow(id{{$qusBank->id}});
    editor{{$qusBank->id}}.reroute = true;
    editor{{$qusBank->id}}.start();
    editor{{$qusBank->id}}.editor_mode = 'edit';
    editor{{$qusBank->id}}.zoom_max = 1;
    editor{{$qusBank->id}}.zoom_min = 1;
    editor{{$qusBank->id}}.zoom_value = 1;


    @if(isset($qusBank->type) && $qusBank->type=='X')
    @foreach($qusBank->questionMuInSerial as $option)

    addNodeToDrawFlow("{{$option->type==1?'qus':'ans'}}", 600, 400, '{{$option->title}}', {{$option->option_index}}, "{{asset($option->image)}}")
    @endforeach
    @endif


    //draw start
    @if(isset($qusBank->type) && $qusBank->type=='X')



    // draw connecetion
    // let connection = document.createElementNS('http://www.w3.org/2000/svg', "svg");
    // let path = document.createElementNS('http://www.w3.org/2000/svg', "path");

    @php
        $pairs =explode(',',$qusBank->connection);
    @endphp
    @foreach ($pairs as $pair)
    @php
        if (empty($pair)){
          continue;
        }
            $inputOutput =explode('|',$pair);
    @endphp
    addExistingConnection({{explode('-',$inputOutput[0])[1]}}, {{explode('-',$inputOutput[1])[1]}})
    @endforeach


    @endif


    function addExistingConnection(id_output, id_input) {
        var connection = document.createElementNS('http://www.w3.org/2000/svg', "svg");
        var path = document.createElementNS('http://www.w3.org/2000/svg', "path");
        path.classList.add("main-path");
        path.setAttributeNS(null, 'd', '');
        connection.classList.add("connection");
        connection.classList.add("node_in_node-" + id_input);
        connection.classList.add("node_out_node-" + id_output);
        connection.classList.add("output_1");
        connection.classList.add("input_1");
        connection.appendChild(path);
        editor{{$qusBank->id}}.precanvas.appendChild(connection);
        editor{{$qusBank->id}}.updateConnectionNodes('node-' + id_output);
        editor{{$qusBank->id}}.updateConnectionNodes('node-' + id_input);
    }

    //draw end


    editor{{$qusBank->id}}.on("clickEnd", (event) => {

        editor{{$qusBank->id}}.editor_selected = false;
    })

    editor{{$qusBank->id}}.on('connectionCreated', function (connection) {

    })

    editor{{$qusBank->id}}.on('connectionRemoved', function (connection) {


    })


    var elements = document.getElementsByClassName('drag-drawflow');
    for (var i = 0; i < elements.length; i++) {
        elements[i].addEventListener('touchend', drop, false);
        elements[i].addEventListener('touchmove', positionMobile, false);
        elements[i].addEventListener('touchstart', drag, false);
    }

    var mobile_item_selec = '';
    var mobile_last_move = null;

    function positionMobile(ev) {
        mobile_last_move = ev;
    }

    function allowDrop(ev) {
        ev.preventDefault();
    }

    function drag(ev) {
        if (ev.type === "touchstart") {
            mobile_item_selec = ev.target.closest(".drag-drawflow").getAttribute('data-node');
        } else {
            ev.dataTransfer.setData("node", ev.target.getAttribute('data-node'));
        }
    }

    function drop(ev) {
        if (ev.type === "touchend") {
            var parentdrawflow = document.elementFromPoint(mobile_last_move.touches[0].clientX, mobile_last_move.touches[0].clientY).closest("#drawflow");
            if (parentdrawflow != null) {
                addNodeToDrawFlow(mobile_item_selec, mobile_last_move.touches[0].clientX, mobile_last_move.touches[0].clientY);
            }
            mobile_item_selec = '';
        } else {
            ev.preventDefault();
            var data = ev.dataTransfer.getData("node");
            addNodeToDrawFlow(data, ev.clientX, ev.clientY);
        }

    }

    function addNodeToDrawFlow(name, pos_x, pos_y, title = '', i = 0, image = '') {

        i = $("#matchingQus{{$qusBank->id}}").find('.' + name + 'Node').length;
        if (editor{{$qusBank->id}}.editor_mode === 'fixed') {
            return false;
        }
        pos_x = pos_x * (editor{{$qusBank->id}}.precanvas.clientWidth / (editor{{$qusBank->id}}.precanvas.clientWidth * editor{{$qusBank->id}}.zoom)) - (editor{{$qusBank->id}}.precanvas.getBoundingClientRect().x * (editor{{$qusBank->id}}.precanvas.clientWidth / (editor{{$qusBank->id}}.precanvas.clientWidth * editor{{$qusBank->id}}.zoom)));
        pos_y = pos_y * (editor{{$qusBank->id}}.precanvas.clientHeight / (editor{{$qusBank->id}}.precanvas.clientHeight * editor{{$qusBank->id}}.zoom)) - (editor{{$qusBank->id}}.precanvas.getBoundingClientRect().y * (editor{{$qusBank->id}}.precanvas.clientHeight / (editor{{$qusBank->id}}.precanvas.clientHeight * editor{{$qusBank->id}}.zoom)));

        switch (name) {
            case 'ans':
                let ansRow = '';
                ansRow += "<div class='row  optionType' data-type='ans' data-index='" + i + "'> ";
                ansRow += "<div class='col-lg-12 optionTitle m-0 p-0'>";

                ansRow += "<div class='align-content-between d-flex justify-content-between primary_label2'>"

                ansRow += "<input class='primary_input3 name ans_title w-100' placeholder='" + title + "'" + i + "' " + "' type='text' name='ans[" + i + "]' value='" + title + "' df-ans autocomplete='off' readonly>";

                if (image) {
                    ansRow += "<div class='image-preview'>";
                    ansRow += `<img src='${image}' alt='Preview' class='img-responsive' id='img-preview-` + i + "'/>";
                    ansRow += "</div>";
                }


                ansRow += "</div>";
                ansRow += "</div>";
                ansRow += "</div>";


                editor{{$qusBank->id}}.addNode('ans', 1, 0, pos_x, pos_y, 'ans', {"ans": title}, ansRow);
                break;
            case 'qus':
                let qusRow = '';
                qusRow += "<div class='row  optionType' data-type='qus' data-index='" + i + "'>";
                qusRow += "<div class='col-lg-12 optionTitle  m-0 p-0'>";
                qusRow += "<div class='align-content-between d-flex justify-content-between primary_label2'>"

                if (image) {
                    qusRow += "<div class='image-preview'>";
                    qusRow += `<img src='${image}' alt='Preview' class='img-responsive' id='img-preview-` + i + "'/>";
                    qusRow += "</div>";
                }

                qusRow += "<input class='primary_input3 name option_title w-100' placeholder=' " + title + "'" + i + "' " + "' type='text' name='qus[" + i + "]' value='" + title + "' df-qus autocomplete='off' readonly>";


                qusRow += "</div>";
                qusRow += "</div>";
                qusRow += "</div>";


                editor{{$qusBank->id}}.addNode('qus', 0, 1, pos_x, pos_y, 'qus', {"qus": title}, qusRow);
                break;


            default:
        }
    }

    editor{{$qusBank->id}}.editor_mode = 'view';
</script>

