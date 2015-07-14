@if(count($quiz))
    {{Form::open(['url'=>'/quiz/take/student/'. $quiz->quiz->id, 'id'=>'takeQuizForm'])}}
        @extends('layouts.header')
        @section('header_content')
            <h5 class="modal-title" id="myModalLabel">
            {{$quiz->quiz->name}} <i class="fa fa-chevron-right fa-fw"></i> Take
            {{Form::submit('Submit', ['class'=>'btn btn-xs btn-primary', 'id'=>'submitbuttontakequiz'])}}
            </h5>
        @stop
        <div class="container margin-top-xxl">
            @if(count($quizItems))
                <div class="list-group-item text-center">
                    <h3>Timer: </h3>
                    <span id="minutes"></span>
                    <span id="dividerofminsec">:</span>
                    <span id="seconds"></span>
                </div>
                <br/><br/>
                <h4 class="title margin-top-sm">Quiz <small class="timeago pull-right">Total: {{$quizItems->count()}}</small></h4>
                <hr id="fit">
                <div class="list-group margin-top-sm">
                    <?php $counter = 1; ?>
                    @foreach($quizItems as $quizItem)
                        <div class="list-group-item margin-top-sm">
                            <p class="margin-top-sm">{{ $counter ++ . '. ' .$quizItem->question}}</p>
                            <div class="form-group margin-top-sm">
                                @foreach($quizItem->quiz_item_choices as $choices)
                                    {{ Form::radio('item['.$choices->quizItemID.']', 'A') . $choices->choice1  }}<br/>
                                    {{ Form::radio('item['.$choices->quizItemID.']', 'B') . $choices->choice2  }}<br/>
                                    {{ Form::radio('item['.$choices->quizItemID.']', 'C') . $choices->choice3  }}<br/>
                                    {{ Form::radio('item['.$choices->quizItemID.']', 'D') . $choices->choice4  }}<br/>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info">No quiz items yet.</div>
            @endif
        </div>
    {{Form::close()}}
@endif

<script type="text/javascript">
    function countdown(duration) {
         // set minutes
         mins = duration;

         // calculate the seconds (don't change this! unless time progresses at a different speed for you...)
         secs = mins * 60;

         Decrement();

    }
    function Decrement() {

         if (secs >= 0) {

             minutes = document.getElementById("minutes");
             seconds = document.getElementById("seconds");

                 if (secs <= 60){
                    jsAPI.showToastFromJava('You only have 60 seconds.');
                     minutes.style.color = "red";
                     seconds.style.color = "red";
                     document.getElementById("dividerofminsec").style.color = "red";
                 }

                 if (secs == 0)
                 {
                    document.forms["takeQuizForm"].submit();
                 }
                 minutes.innerHTML = getminutes();
                 seconds.innerHTML = getseconds();

             secs--;

             setTimeout(function() {
                 Decrement();
             }, 1000)


         }
     }
    function getminutes() {
         // minutes is seconds divided by 60, rounded down
         mins = Math.floor(secs / 60).length > 1 ? Math.floor(secs / 60): '0' + Math.floor(secs / 60);
         return mins;
         }
         function getseconds() {
         // take mins remaining (as seconds) away from total seconds remaining
         return secs-Math.round(mins *60).length > 1 ? secs-Math.round(mins *60) : '0' + secs-Math.round(mins *60);
    }
    countdown({{$quiz->duration}})
</script>