<div>
    <style>
        .singleBranch {
            display: flex;
            grid-gap: 5px;
        }

        .positionList tbody th, .positionList tbody td {
            padding: 0 !important;
            margin: 0 !important;
        }


        .positionList .primary_checkbox input:not([checked]) ~ .checkmark:before {
            display: none;
        }

        .positionList .primary_checkbox input:not([checked]) ~ .checkmark:after {
            transform: scale(1);
            border: 1px solid #828bb2;
        }

        .positionList .primary_checkbox input:not([checked]) ~ .checkmark {
            box-shadow: 0 0 0;
            background: transparent;
        }

        .positionList .primary_checkbox input[checked] ~ .checkmark:before {
            content: "\E64C";
            font-family: themify;
            position: absolute;
            display: block;
            top: 0;
            left: 3px;
            text-indent: 1px;
            color: #828bb2;
            background-color: transparent;
            border: 0;
            transform: rotate(8deg);
            font-size: 10px;
            font-weight: 600;
            line-height: 18px;
            z-index: 99;
            color: #fff;
            transition: .3s;
        }

        .positionList .primary_checkbox input[checked] ~ .checkmark:after {
            transform: scale(0);
            border: 0;
        }

        .positionList .primary_checkbox input[checked] ~ .checkmark {
            background: linear-gradient(90deg, var(--backend-primary-color) .47%, var(--backend-primary-color));
            box-shadow: 0 5px 10px rgb(108 39 255 / 25%);
        }

        .positionList .active {
            font-weight: 600 !important;
            font-size: 14px !important;
            color: var(--backend-primary-color) !important;
        }
    </style>
    <table id="" class="table  positionList "
           wire:ignore
    >
        <tbody>

        @foreach($positions as $key=>$position)

            <tr>
                <td>
                    <a href="#"
                       data-id="{{$position->id}}"
                       data-parent="0"
                       class="activeBranchCode {{isset($edit_positions)?in_array($position->id, $edit_positions) ? 'active' : '' :'' }} "
                    >
                        <span>{{$position->name}}</span>
                    </a>
                </td>
                <td class="" style="padding: 0">
                    <label class="primary_checkbox d-flex " for="position-{{$position->id}}">
                        <input type="checkbox" id="position-{{$position->id}}" name="position[]"
                               class=" common-checkbox checkPosition"
                               value="{{$position->id}}" {{isset($edit_positions)?in_array($position->id, $edit_positions) ? 'checked' : '' :'' }}

                        >
                        <span class="checkmark"></span>
                    </label>
                </td>
            </tr>

        @endforeach


        </tbody>
    </table>

    @push('js')

        <script>

            $(document).ready(function () {

                $(document).on('keyup', '#searchPosition', function () {
                    let search = this.value;

                    let jo = $('.positionList tbody').find("tr");

                    if (this.value == "") {
                        jo.show();
                        return;
                    }
                    jo.hide();

                    jo.filter(function (i, v) {
                        var $t = $(this);
                        let title = $t.closest('tr').find('td').eq(0).text().trim();
                        let code = $t.closest('tr').find('td').eq(1).text().trim();
                        if (title.toLowerCase().indexOf(search.toLowerCase()) > -1 || code.toLowerCase().indexOf(search.toLowerCase()) > -1) {
                            return true;
                        }
                        return false;
                    }).show();
                });
            });

        </script>
        <script>

            function showPreloader() {
                $.LoadingOverlay("show");
            }

            function hidePreloader() {
                $.LoadingOverlay("hide");
            }


            $(document).on("click", ".checkPosition", function () {
                $.LoadingOverlay("show");
                let item = $(this);


                let itemStatus = item.is(":checked")


                item.attr('checked', itemStatus)
                console.log(itemStatus)
                if (itemStatus) {
                    item.closest('tr').find('.activeBranchCode').addClass('active');
                } else {
                    item.closest('tr').find('.activeBranchCode').removeClass('active');

                }
                $.LoadingOverlay("hide");
            });

        </script>

    @endpush
</div>
