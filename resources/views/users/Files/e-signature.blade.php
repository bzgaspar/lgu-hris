@extends('layouts.app')

@section('title', 'E Signature')
@section('customCSS')
    <link rel="stylesheet" href="{{ asset('css/signiature-pad.css') }}">
    <link type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css"
        rel="stylesheet">
@endsection

@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success  alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    @endif

    <form action="{{ route('users.eSignature.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12 col-md">
                <div class="wrapper mx-auto">
                    <canvas id="signature-pad" class="signature-pad" width=300 height=300></canvas>
                </div>
                <br />
                <textarea id="signature64" hidden name="signature"></textarea>
                <div class="row">
                    <div class="col-12 col-md">
                        <button type="button" onclick="clearCanvass()" class="btn btn-danger w-100">Clear
                            Signature</button>
                    </div>
                    <div class="col-12 col-md"><button type="submit" onclick="addSignature()"
                            class="btn btn-success w-100">
                            <i class="fa-solid fa-plus me-1"></i>Add
                        </button></div>
                </div>
            </div>
            <div class="col-12 col-md text-center">
                @if ($signature)
                    <img class="border border-dark" src="{{ $signature->signature }}" alt="" width=300 height=300>
                    <br>
                    Current Signature
                @endif
            </div>
        </div>
        <br />
    </form>
@endsection


@section('customJS')
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript"
        src="https://cdn.jsdelivr.net/npm/signature_pad@3.0.0-beta.3/dist/signature_pad.umd.min.js"></script>
    <script>
        var signaturePad = new SignaturePad(document.getElementById("signature-pad"), {
            backgroundColor: "rgba(255, 255, 255, 0)",
            penColor: "rgb(0, 0, 0)",
        });

        var signed = document.getElementById('signature64');

        function addSignature() {
            var data = signaturePad.toDataURL();
            signed.value = data;

        }

        function clearCanvass() {
            signaturePad.clear();
        }
    </script>
@endsection
