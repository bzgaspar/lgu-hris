@extends('layouts.app')

@section('title', 'EditF OPCR')
@section('content')
    <div class="row">
        <div class="col">
            <a href="{{ route('users.IPCR.create') }}" class="btn btn-outline-success border-0">
                <i class="fa-solid fa-arrow-left me-1"></i>Back
            </a>
        </div>
    </div>
    <form action="{{ route('users.OPCR.update', $my_opcr->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="row justify-content-end">
            <div class="col-2 p-1">
                <div class="form-floating mb-1">
                    <input type="month" class="form-control form-control-sm" name="from" id="from"
                        placeholder="From" value="{{ $my_opcr->from }}">
                    <label for="from">From</label>
                </div>
                @error('from')
                    <p class="text-danger" style="font-size: 10px">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-2 p-1">
                <div class="form-floating mb-1">
                    <input type="month" class="form-control form-control-sm" name="to" id="to"
                        placeholder="To" value="{{ $my_opcr->to }}">
                    <label for="to">To</label>
                </div>
                @error('to')
                    <p class="text-danger" style="font-size: 10px">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="row justify-content-center mb-4">
            <div class="col-12">
                <div class="row gx-2 mt-3">
                    <div class="col-4 p-2  border border-success rounded">MFO/PAP</div>
                    <div class="col-4 p-2  border border-success rounded">SUCCESS INDICATORS</div>
                    <div class="col-2 p-2  border border-success rounded">Allotted Budget</div>
                    <div class="col-2 p-2  border border-success rounded">Individual/Department Accountable</div>
                </div>
                <div class="row gx-2 mt-3">
                    <div class="col-6 p-2  border border-success rounded">Actual</div>
                    <div class="col-4 p-2  border border-success rounded">Rating</div>
                    <div class="col-1 p-2  border border-success rounded">Remarks</div>
                </div>
                <div class="row">
                    <div class="col-2">
                        @error('question')
                            <p class="text-danger" style="font-size: 10px">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-2">
                        @error('indicators')
                            <p class="text-danger" style="font-size: 10px">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-4">
                        @error('actual')
                            <p class="text-danger" style="font-size: 10px">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-2">
                        @error('rate4')
                            <p class="text-danger" style="font-size: 10px">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-2">
                        @error('remarks')
                            <p class="text-danger" style="font-size: 10px">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div id="rowInHere" class="mb-0">

                    @foreach ($my_opcr->ipcr_forms_details as $opcr)
                        <div>
                            <div class="row gx-1 border mt-3 border-dark rounded" id="{{ $loop->iteration - 1 }}">
                                <div class="col-12 col-md-4 p-2">
                                    <select class="form-select form-select-sm" name="question[]" id="question"
                                        placeholder="Question">
                                        <option value="">Select question</option>
                                        '@forelse ($all_mfo_question as $item)
                                            @if ($opcr->ques1 === $item->id)
                                                <option selected value="{{ $item->id }}">{{ $item->type }} |
                                                    {{ $item->question }}
                                                </option>
                                            @else
                                                <option value="{{ $item->id }}">{{ $item->type }} |
                                                    {{ $item->question }}
                                                </option>
                                            @endif
                                        '@empty
                                            <option selected>No question Yet</option>
                                            '
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col-12 col-md-4 p-2">
                                    <select class="form-select form-select-sm" name="indicators[]" id="indicators"
                                        placeholder="Indicators">
                                        <option>Select question</option>
                                        '@forelse ($all_indicators as $item)
                                            @if ($opcr->ques2 === $item->id)
                                                <option selected value="{{ $item->id }}">{{ $item->type }} |
                                                    {{ $item->question }}
                                                </option>
                                            @else
                                                <option value="{{ $item->id }}">{{ $item->question }}</option>
                                            @endif
                                        '@empty
                                            <option selected>No question Yet</option>
                                            '
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col-12 col-md-2 p-2">
                                    <input class="form-control form-control-sm" name="budget[]" placeholder="Budget"
                                        value="{{ $opcr->ans1 }}" type="text" />
                                </div>
                                <div class="col-12 col-md-2 p-2">
                                    <input class="form-control form-control-sm" name="accountable[]"
                                        placeholder="Accountable" value="{{ $opcr->ans2 }}" type="text" />
                                </div>
                                <div class="col-12 col-md-6 p-2">
                                    <input class="form-control form-control-sm" name="actual[]" placeholder="Acutal"
                                        value="{{ $opcr->ans3 }}" type="text" />
                                </div>
                                <div class="col-12 col-md-4 p-2">
                                    <div class="row gx-0 p-0 m-0">
                                        <div class="col p-0">
                                            <input class="form-control form-control-sm" name="rate1[]" type="text"
                                                id="rate1[{{ $loop->iteration - 1 }}]"
                                                onkeyup="getAverageRow({{ $loop->iteration - 1 }})"
                                                value="{{ $opcr->rate1 }}" placeholder="Q" />
                                        </div>
                                        <div class="col p-0">
                                            <input class="form-control form-control-sm"
                                                id="rate2[{{ $loop->iteration - 1 }}]"
                                                onkeyup="getAverageRow({{ $loop->iteration - 1 }})"
                                                name="rate2[]"type="text" value="{{ $opcr->rate2 }}" placeholder="E" />
                                        </div>
                                        <div class="col p-0">
                                            <input class="form-control form-control-sm"
                                                id="rate3[{{ $loop->iteration - 1 }}]"
                                                onkeyup="getAverageRow({{ $loop->iteration - 1 }})" name="rate3[]"
                                                value="{{ $opcr->rate3 }}" type="text" placeholder="T" />
                                        </div>
                                        <div class="col p-0">
                                            <input class="form-control form-control-sm"
                                                id="rate4[{{ $loop->iteration - 1 }}]" name="rate4[]"type="text"
                                                onkeyup="getAverageRow({{ $loop->iteration - 1 }})"
                                                value="{{ $opcr->rate4 }}" placeholder="A" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-1 p-2">
                                    <input class="form-control form-control-sm" name="remarks[]"
                                        placeholder="Remarks"type="text" value="{{ $opcr->remarks }}" />
                                </div>
                                <div class="col-12 col-md-1 p-2">
                                    <button type="button" class="text-danger"
                                        onclick="deleteRow({{ $loop->iteration - 1 }})"><i
                                            class="fa-solid fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <button type="button" class="btn btn-secondary btn-sm text-white fw-bold" value="Add V"
                    onclick="AddRow();">Click here
                    to add
                    row</button>
            </div>
            <div class="col text-end">
                <button id="add_btn" type="submit" class="btn btn-success btn-sm px-5">
                    <i class="fa-solid fa-check me-1"></i>
                    Save</button>
            </div>
        </div>
    </form>
    <users-opcr-table user_id="{{ Auth::user()->id }}"></users-opcr-table>
@endsection

@section('customJS')
    <script>
        var row = 0;

        const myDiv = document.getElementById('rowInHere');
        const divChildren = myDiv.children;
        // console.log(divChildren)
        row = divChildren.length

        function AddRow() {
            // First create a DIV element.
            var txtNewInputBox = document.createElement("div");

            // Then add the content (a new input box) of the element.
            txtNewInputBox.innerHTML =
                `<div class="row gx-1 border mt-3 border-dark rounded" id="` +
                row + `">` +
                `<div class="col-12 col-md-4 p-2">` +
                `<select class="form-select form-select-sm" name="question[]" id="question" placeholder="Question">` +
                `<option value="" >Select question</option>` +
                `@forelse ($all_mfo_question as $item)` +
                `<option value="{{ $item->id }}">{{ $item->type }} | {{ $item->question }}` +
                `</option>` +
                `@empty` +
                `<option selected>No question Yet</option>` +
                `@endforelse` +
                `</select>` +
                `</div>` +
                `<div class="col-12 col-md-4 p-2">` +
                `<select class="form-select form-select-sm" name="indicators[]"  id="indicators" placeholder="Indicators">` +
                `<option >Select question</option>` +
                `@forelse ($all_indicators as $item)` +
                `<option value="{{ $item->id }}">{{ $item->type }} | {{ $item->question }}</option>` +
                `@empty` +
                `<option selected>No question Yet</option>` +
                `@endforelse` +
                `</select>` +
                `</div>` +
                `<div class="col-12 col-md-2 p-2">` +
                `<input class="form-control form-control-sm" name="budget[]"  placeholder="Budget" type="text" />` +
                `</div>` +
                `<div class="col-12 col-md-2 p-2">` +
                `<input class="form-control form-control-sm" name="accountable[]"  placeholder="Accountable" type="text" />` +
                `</div>` +
                `<div class="col-12 col-md-6 p-2">` +
                `<textarea rows="1" class="form-control form-control-sm" name="actual[]" placeholder="Acutal"></textarea>` +
                `</div>` +
                `<div class="col-12 col-md-4 p-2">` +
                `<div class="row gx-0 p-0 m-0">` +
                `<div class="col p-0">` +
                `<input class="form-control form-control-sm" id="rate1[` + row +
                `]" onkeyup="getAverageRow(` + row +
                `)" name="rate1[]" type="text" placeholder="Q" />` +
                `</div>` +
                `<div class="col p-0">` +
                `<input class="form-control form-control-sm" id="rate2[` + row +
                `]" name="rate2[]" onkeyup="getAverageRow(` + row + `)" type="text" placeholder="E" />` +
                `</div>` +
                `<div class="col p-0">` +
                `<input class="form-control form-control-sm" id="rate3[` + row +
                `]" name="rate3[]" onkeyup="getAverageRow(` + row + `)" type="text" placeholder="T"  />` +
                `</div>` +
                `<div class="col p-0">` +
                `<input class="form-control form-control-sm" id="rate4[` + row +
                `]" name="rate4[]" onkeyup="getAverageRow(` + row + `)" type="text" placeholder="A" />` +
                `</div>` +
                `</div>` +
                `</div>` +
                `<div class="col-12 col-md-1 p-2">` +
                `<input class="form-control form-control-sm" name="remarks[]" placeholder="Remarks"type="text" />` +
                `</div>` +
                `<div class="col-12 col-md-1 p-2">` +
                `<button type="button" class="text-danger" onclick="deleteRow(` + row +
                `)"><i class="fa-solid fa-trash"></i></button>` +
                `</div>` +
                `</div>`;


            // Finally put it where it is supposed to appear.
            document.getElementById("rowInHere").appendChild(txtNewInputBox);
            row++;
        }

        function deleteRow(val) {
            if (confirm("Are you sure you want to delete this row?")) {
                const divToDelete = document.getElementById(val);
                if (divToDelete) {
                    divToDelete.parentNode.removeChild(divToDelete);
                }
            }
        }

        function enableBTN() {
            let from = document.getElementById('from').value;
            let to = document.getElementById('to').value;

            if (from && to) {
                document.getElementById('add_btn').disabled = false;
            } else {
                document.getElementById('add_btn').disabled = true;
            }
        }

        function checkValues() {
            const selectElements = document.querySelectorAll('[name="question[]"]');

            // Initialize an array to store selected options
            const selectedOptions = [];

            // Loop through each select element
            selectElements.forEach((selectElement) => {
                // Get the selected option
                const selectedOption = selectElement.options[selectElement.selectedIndex];

                // Check if an option is selected
                if (selectedOption) {
                    selectedOptions.push(selectedOption.text);
                }
            });

            selectedOptions.forEach(val => {
                console.log(val.split(' | '))
            });
        }

        function getAverageRow(rowNumber) {
            let arr = []
            let r1 = parseFloat(document.getElementById('rate1[' + rowNumber + ']').value);
            let r2 = parseFloat(document.getElementById('rate2[' + rowNumber + ']').value);
            let r3 = parseFloat(document.getElementById('rate3[' + rowNumber + ']').value);
            // if (r1 && r2 && r3) {
            //     document.getElementById('rate4[' + rowNumber + ']').value = (r1 + r2 + r3) / 3
            // }
            if (r1) {
                arr[0] = r1
            }
            if (r2) {
                arr[1] = r2
            }
            if (r3) {
                arr[2] = r3
            }
            let total = 0;
            arr.forEach(val => {
                total += val
            });
            let average = total / arr.length;
            if (!isNaN(average)) {
                document.getElementById('rate4[' + rowNumber + ']').value = parseFloat(average.toFixed(2))
            } else {
                document.getElementById('rate4[' + rowNumber + ']').value = ""
            }
        }
    </script>

@endsection
