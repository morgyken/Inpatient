<div class="panel panel-info">
    <div class="panel-heading">
        <h5>Previous Nurse Notes</h5>
    </div>

    <div class="panel-body items-container">
        <div class="accordion">
            @foreach($notes as $note)
                <h4>
                    <span>{{ $note['title'] }}</span>
                    <span class="pull-right">{{ $note['date'] }}</span>
                </h4>
                <div>
                    {{ $note['body'] }}
                </div>
            @endforeach    
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.accordion').accordion({heightStyle: "content"});    
    })
</script>