<h2 class="text-center">Vital Charts</h2>
<!-- Temperature Chart Canvas -->
<div class="chart">
	<div id="temp_chart"></div>
	@areachart('tempChart', 'temp_chart')
</div>

{{-- Blood Pressure Chart --}}
<div class="chart">
	<div id="bp_chart"></div>
	@areachart('bpChart', 'bp_chart')
	
</div>

<!-- Weight-Height Chart Canvas -->
<div class="chart">
    <div id="wh_chart"></div>
    {{-- @areachart('whChart', 'wh_chart') --}}
</div>

<!-- /.chart-responsive -->