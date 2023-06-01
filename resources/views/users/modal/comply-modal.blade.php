<!-- Modal -->
<div class="modal fade" id="comply-{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('users.surveyAnswer.update', $item->surveyAnswerDetails->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Comply With
                        {{ $item->surveyQuestion->question }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Upload the training certificate that u aquired in compliance of your training needs.</p>
                    <input type="file" class="form-control" accept=".pdf" name="comply_file" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-success " data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-outline-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
