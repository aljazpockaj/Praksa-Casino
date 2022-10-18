<div class="content">
    <div class="title m-b-md">
    </div>
    @foreach($bets as $bet)
    <div>
    {{$bet -> agentid}} - {{$bet -> bet}} - {{$bet -> currency}} - {{$bet -> date}} - {{$bet -> fin}} - {{$bet -> id}} - {{$bet -> net}} - {{$bet -> playerid}} - {{$bet -> rake}} - {{$bet -> tournament}} - {{$bet -> win}}     
    </div>
    @endforeach
</div>