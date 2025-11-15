<script src="{{asset('public/plugins/drawflow/drawflow.js')}}"></script>
<link rel="stylesheet" href="{{asset('public/plugins/drawflow/drawflow.css')}}">
<script>
    let connections = $('#connection').val();
    let options = connections.split(",");

    var id = document.getElementById("drawflow");
    const editor = new Drawflow(id);
    editor.reroute = true;
    editor.start();
    editor.editor_mode = 'edit';
    editor.zoom_max = 1;
    editor.zoom_min = 1;
    editor.zoom_value = 1;


    @if(isset($bank->type) && $bank->type=='X')
    @foreach($bank->questionMuInSerial as $option)
    addNodeToDrawFlow("{{$option->type==1?'qus':'ans'}}", 600, 400, '{{$option->title}}', {{$option->option_index}}, {{$option->image_media?->media_id}})
    @endforeach


    // draw connecetion
    let connection = document.createElementNS('http://www.w3.org/2000/svg', "svg");
    let path = document.createElementNS('http://www.w3.org/2000/svg', "path");

    @php
        $pairs =explode(',',$bank->connection);
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
        editor.precanvas.appendChild(connection);
        editor.updateConnectionNodes('node-' + id_output);
        editor.updateConnectionNodes('node-' + id_input);
    }


    editor.on("clickEnd", (event) => {

        editor.editor_selected = false;
    })

    editor.on('connectionCreated', function (connection) {
        console.log('Connection created');
        checkConnection(connection, 'add')
    })

    editor.on('connectionRemoved', function (connection) {
        console.log('Connection removed');
        checkConnection(connection, 'remove')
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

    function addNodeToDrawFlow(name, pos_x, pos_y, title = '', i = 0,media_id=0) {
        let placeholder = title
        @if(!isset($bank->type))
            title = '';
        @endif
            i = $('.' + name + 'Node').length;
        if (editor.editor_mode === 'fixed') {
            return false;
        }
        pos_x = pos_x * (editor.precanvas.clientWidth / (editor.precanvas.clientWidth * editor.zoom)) - (editor.precanvas.getBoundingClientRect().x * (editor.precanvas.clientWidth / (editor.precanvas.clientWidth * editor.zoom)));
        pos_y = pos_y * (editor.precanvas.clientHeight / (editor.precanvas.clientHeight * editor.zoom)) - (editor.precanvas.getBoundingClientRect().y * (editor.precanvas.clientHeight / (editor.precanvas.clientHeight * editor.zoom)));

        switch (name) {
            case 'ans':
                let ansRow = '';
                ansRow += "<div class='row  optionType' data-type='ans' data-index='" + i + "'> ";
                ansRow += "<div class='col-lg-12 optionTitle m-0 p-0'>";


                ansRow += "<div class='input-effect d-flex justify-content-between align-items-center gap-3'>"

                ansRow += "<input class='primary_input_field name ans_title' placeholder='" + placeholder + "'" + i + "' " + "' type='text' name='ans[" + i + "]' value='" + title + "' df-ans autocomplete='off' >";


                ansRow += `<x-upload-file
    name="answer_image[${i}]"
    type="image"
    media_id="${media_id}"
    label=""
    />`;


                ansRow += "</div>";
                ansRow += "</div>";
                ansRow += "</div>";


                editor.addNode('ans', 1, 0, pos_x, pos_y, 'ans', {"ans": title}, ansRow);
                break;
            case 'qus':
                let qusRow = '';
                qusRow += "<div class='row  optionType' data-type='qus' data-index='" + i + "'>";
                qusRow += "<div class='col-lg-12 optionTitle  m-0 p-0'>";
                qusRow += "<div class='input-effect d-flex justify-content-between align-items-center gap-3'>"


                qusRow += `<x-upload-file
    name="question_image[${i}]"
    type="image"
    media_id="${media_id}"
    label=""
    />`;
                qusRow += "<input class='primary_input_field name option_title ' placeholder=' " + placeholder + "'" + i + "' " + "' type='text' name='qus[" + i + "]' value='" + title + "' df-qus autocomplete='off' required>";




                qusRow += "</div>";
                qusRow += "</div>";
                qusRow += "</div>";


                editor.addNode('qus', 0, 1, pos_x, pos_y, 'qus', {"qus": title}, qusRow);
                break;


            default:
        }
    }


    $(document).on("click", "#create-qus-option", function (event) {
        let qusItem = $('#number_of_qus');
        let qusTitle = qusItem.data('title');

        let qus = editor.getNodesFromName('qus');
        $.each(qus, function (index, val) {
            $('#node-' + val).closest('.parent-node').remove()
        });

        for (i = 0; i < qusItem.val(); i++) {
            addNodeToDrawFlow('qus', 600, 400, qusTitle, i)
        }
    });

    $(document).on("click", "#create-ans-option", function (event) {
        let ansItem = $('#number_of_ans');
        let ansTitle = ansItem.data('title');

        let ans = editor.getNodesFromName('ans');
        $.each(ans, function (index, val) {
            $('#node-' + val).closest('.parent-node').remove()
        });

        for (i = 0; i < ansItem.val(); i++) {
            addNodeToDrawFlow('ans', 900, 400, ansTitle, i)
        }
    });

    function checkConnection(connection, status) {
        let input_id = connection.input_id;
        let output_id = connection.output_id;
        // // console.log('check', output_id, input_id)
        let inputOptionType = $('#node-' + input_id).find('.optionType')
        let outOptionType = $('#node-' + output_id).find('.optionType')

        let inputIndex = inputOptionType.data('index');
        let outputIndex = outOptionType.data('index');
        // let output = outputIndex + '|' + inputIndex;

        let output = outputIndex + '-' + output_id + '|' + inputIndex + '-' + input_id;

        if (status == 'add') {
            options.push(output);
        } else if (status == 'remove') {
            options = options.filter(function (elem) {
                return elem != output;
            });
        }

        $('#connection').val(options)

    }


</script>
