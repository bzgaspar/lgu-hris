<div class="container">
    <h6 class="text-muted mt-2 mb-4">
        In this Section is where to set the different exams and add scores as the basis for the ranking of applicants.

        <br>
    </h6>
    <hr>
    @if ($additionalPoints && $interviewExamRated)

        <div class="row justify-content-center">
            {{-- written --}}
            <div class="col-12 col-sm-6 col-md-4 mb-3">
                <form action="{{ route('hr.interview.update', $interviewExam->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <small id="written_exam_date" class="form-text text-muted">Please set the date of the exam first
                        before
                        adding rating.</small>
                    <div class="input-group mb-3">
                        <div class="form-floating">
                            <input type="datetime-local" class="form-control" name="written_exam_date"
                                id="written_exam_date" aria-describedby="written_exam_date"
                                @if ($interviewExam->written_exam_date) value="{{ $interviewExam->written_exam_date }}" @endif>
                            <label for="written_exam_date">Set Written Exam Date</label>
                        </div>
                        <button class="btn btn-outline-success " type="submit">Set</button>
                    </div>
                    @error('written_exam_date')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </form>
            </div>
            <div class="col-12 col-sm-6 col-md-4 mb-3">
                <form action="{{ route('hr.interview.update', $interviewExam->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <small id="oral_exam_date" class="form-text text-muted">Please set the date of the exam first
                        before
                        adding rating.</small>
                    <div class="input-group mb-3">
                        <div class="form-floating">
                            <input type="datetime-local" class="form-control" name="oral_exam_date" id="oral_exam_date"
                                aria-describedby="oral_exam_date"
                                @if ($interviewExam->oral_exam_date) value="{{ $interviewExam->oral_exam_date }}" @endif>
                            <label for="oral_exam_date">Set Oral Exam / Interview Date</label>
                        </div>
                        <button class="btn btn-outline-success " type="submit">Set</button>
                    </div>
                    @error('oral_exam_date')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </form>
            </div>
        </div>
        <div class="row">
            @if ($interviewExamRated)
                <form action="{{ route('hr.interview.update', $interviewExamRated->id) }}" method="POST">
                    @method('PATCH')
                    <input type="hidden" name="additionalPoints_id" value="{{ $additionalPoints->id }}">
                @else
                    <form action="{{ route('hr.interview.store') }}" method="POST">
            @endif

            @csrf
            <input type="hidden" name="app_id" value="{{ $interviewExam->app_id }}">
            <input type="hidden" name="user_id" value="{{ $interviewExam->user_id }}">
            <input type="hidden" name="pub_id" value="{{ $interviewExam->pub_id }}">
            <div class="row">
                <div class="col">
                    <div class="form-floating">
                        <input type="text" min="0" max="100" step="any" class="form-control"
                            name="experience" id="experience" aria-describedby="experience" placeholder="experience"
                            @if ($interviewExamRated) value="{{ old('experience', $additionalPoints->experience) }}"
                        @else
                        value="{{ old('experience') }}" @endif>
                        <label for="experience">Experience</label>
                    </div>
                    <small id="experience" class="form-text text-muted">The rating range is only 0 to 100</small>
                    @error('experience')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col">
                    <div class="form-floating">
                        <input type="text" min="0" max="100" step="any" class="form-control"
                            name="education" id="education" aria-describedby="education" placeholder="education"
                            @if ($interviewExamRated) value="{{ old('education', $additionalPoints->education) }}"
                        @else
                        value="{{ old('education') }}" @endif>
                        <label for="education">Education</label>
                    </div>
                    <small id="education" class="form-text text-muted">The rating range is only 0 to 100</small>
                    @error('education')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col">
                    <div class="form-floating">
                        <input type="text" min="0" max="100" step="any" class="form-control"
                            name="eligibility" id="eligibility" aria-describedby="eligibility"
                            placeholder="Psycho-social - Personal Traits"
                            @if ($interviewExamRated) value="{{ old('eligibility', $additionalPoints->eligibility) }}"
                        @else
                        value="{{ old('eligibility') }}" @endif>
                        <label for="eligibility">Eligibility</label>
                    </div>
                    <small id="eligibility" class="form-text text-muted">The rating range is only 0 to 100</small>
                    @error('eligibility')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-floating">
                        <input type="text" min="0" max="100" step="any" class="form-control"
                            name="written_exam" id="written_exam" aria-describedby="written_exam"
                            placeholder="Written Exam"
                            @if ($interviewExamRated) value="{{ old('written_exam', $interviewExamRated->written_exam) }}"
                        @else
                        value="{{ old('written_exam') }}" @endif>
                        <label for="written_exam"> Written Exam</label>
                    </div>
                    <small id="written_exam" class="form-text text-muted">The rating range is only 0 to 100</small>
                    @error('written_exam')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col">
                    <div class="form-floating">
                        <input type="text" min="0" max="100" step="any" class="form-control"
                            name="oral_exam" id="oral_exam" aria-describedby="oral_exam"
                            placeholder="Oral Exam Rating"
                            @if ($interviewExamRated) value="{{ old('oral_exam', $interviewExamRated->oral_exam) }}"
                        @else
                        value="{{ old('oral_exam') }}" @endif>
                        <label for="oral_exam">Oral Exam</label>
                    </div>
                    <small id="oral_exam" class="form-text text-muted">The rating range is only 0 to 100</small>
                </div>
                <div class="col">
                    <div class="form-floating">
                        <input type="text" min="0" max="100" step="any" class="form-control"
                            name="background" id="background" aria-describedby="background"
                            placeholder="Background Investigation"
                            @if ($interviewExamRated) value="{{ old('background', $interviewExamRated->background) }}"
                        @else
                        value="{{ old('background') }}" @endif>
                        <label for="background">Background Investigation</label>
                    </div>
                    <small id="background" class="form-text text-muted">The rating range is only 0 to 100</small>
                    @error('background')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-floating">
                        <input type="text" min="0" max="100" step="any" class="form-control"
                            name="performance" id="performance" aria-describedby="performance"
                            placeholder="Performance"
                            @if ($interviewExamRated) value="{{ old('performance', $interviewExamRated->performance) }}"
                        @else
                        value="{{ old('performance') }}" @endif>
                        <label for="performance"> Performance</label>
                    </div>
                    <small id="performance" class="form-text text-muted">The rating range is only 0 to 100</small>
                    @error('performance')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col">
                    <div class="form-floating">
                        <input type="text" min="0" max="100" step="any" class="form-control"
                            name="pspt" id="pspt" aria-describedby="pspt"
                            placeholder="Psycho-social - Personal Traits"
                            @if ($interviewExamRated) value="{{ old('pspt', $interviewExamRated->pspt) }}"
                        @else
                        value="{{ old('pspt') }}" @endif>
                        <label for="pspt">Psycho-social - Personal Traits</label>
                    </div>
                    <small id="pspt" class="form-text text-muted">The rating range is only 0 to 100</small>
                    @error('pspt')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col">
                    <div class="form-floating">
                        <input type="text" min="0" max="100" step="any" class="form-control"
                            name="potential" id="potential" aria-describedby="potential" placeholder="Potential"
                            @if ($interviewExamRated) value="{{ old('potential', $interviewExamRated->potential) }}"
                        @else
                        value="{{ old('potential') }}" @endif>
                        <label for="potential">Potential</label>
                    </div>
                    <small id="potential" class="form-text text-muted">The rating range is only 0 to 100</small>
                    @error('potential')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="row mb-5">
                <div class="col">
                    <button class="btn btn-success w-100" type="submit">Save!</button>
                </div>
            </div>
            </form>
        </div>
    @endif
</div>
