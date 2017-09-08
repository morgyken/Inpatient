<?php
$investigations = $visit->investigations->where('type', 'laboratory')->where('has_result', false);
$results = $visit->investigations->where('type', 'laboratory')->where('has_result', true);
?>
<div role="tabpanel" id="proceduresTab" class="tab-pane fade">
    <br/>
    <br/>
    <div class="form-horizontal">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul id="tabs" class="nav nav-tabs">
                    <li class="active">
                        <a href="#ordered" data-toggle="tab">
                            Ordered Labs<span class="badge alert-info">{{$investigations->count()}}</span>
                        </a>
                    </li>
                    <li>
                        <a href="#new" data-toggle="tab">
                            Order labs <span class="badge alert-success">new</span></a>
                    </li>
                    <li>
                        <a href="#results" data-toggle="tab" id="view_results">
                            Lab Results <span class="badge alert-success">{{$results->count()}}</span>
                        </a>
                    </li>

                    @if($results->count()>0)
                        <li>
                            <a target="blank"
                               href="{{route('evaluation.print.print_res', ['visit'=>$visit,'type'=>$category])}}">
                                Print Results<span class="badge alert-success"></span></a>
                        </li>
                    @endif
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active " id="ordered">
                        @include('evaluation::partials.common.investigations.ordered')
                    </div>
                    <div class="tab-pane" id="new">
                        @include('evaluation::partials.labs.new')
                    </div>
                    <div class="tab-pane" id="results">
                        @include('evaluation::partials.common.investigations.res')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>