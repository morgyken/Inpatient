<link rel="stylesheet" href="{{url('/css/app.css')}}">
<style>
	body{
		padding: 1%;
	}
    table{
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    table th{
        /*border: 1px solid #ddd;*/
        text-align: left;
        padding: 1px;
    }

    table th{
        padding-top: 1px;
        padding-bottom: 1px;
        color: #333;
    }
    h4{
        font-weight: bold !important;
        color: #000 !important;
    }
    .left{
        width: 60%;
        float: left;
    }
    .right{
        float: left;
        width: 40%;
    }
    .clear{
        clear: both;
    }
    img{
    	margin: 0 auto;
        width:100%;
    }
    td{
        font-size: 80%;
    }
    div #footer{
        font-size: 70%;
    }
    th{
        font-size: 90%;
    }

    .sections{
    	margin-bottom: 10px;
    }

    .sections h4{
    	text-decoration: underline;
    }

    #print-header{
    	border: none !important;
    }

    #logo-side{
    	width: 30%;
    }

    #company-info-side{
    	width: 70%;
    	font-size: 
    }

    #company-name{
    	font-size: 3em;
    }

    #company-details{
    	font-size: 1em;
    }
</style>

<div class="box box-info">
	<table id = "print-header">
		<thead>
			<tr>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<tr id = "header-tr">
				<td id = "logo-side"><img src="{{ asset('/logos/collabmed14dDqP.png') }}"/></td>
				<td id = "company-info-side" class="text-center">
					<h3 id ="company-name">{{ strtoupper(config('practice.name')) }}</h3>
					<span id = "company-details">
				        {{ config('practice.building') ? config('practice.building').',' : ''}}
				        {{ config('practice.street') ? config('practice.street').',' : ''}}
				        {{ config('practice.town') }}<br>
				        {{ config('practice.address') ? 'P.O.Box '. config('practice.address').',' : '' }}
				        {{ config('practice.telephone') ? 'Tell: '. config('practice.telephone') : ''}}<br/>
				        {{ config('practice.email') ? 'Email: '. strtolower(config('practice.email')) : ''}}
			    	</span>
			    </td>
			</tr>
		</tbody>
	</table>

    <div class="box-body">
    	<table class="table">
    		<thead>
    			<tr>
    				<th colspan="4"><h2 class="text-center"><u>DISCHARGE SUMMARY</u></h2></th>
    			</tr>
    		</thead>
    		<tbody>
    			<tr>
    				<th>NAME OF PATIENT:</th>
    				<td>{{ $admission->patient->fullname }}</td>
    				<th>IP. NO.</th>
    				<td>{{ $admission->id }}</td>
    			</tr>
    			<tr>
    				<th>DATE OF ADMISSION</th>
    				<td>{{ $admission->created_at->format('jS M, Y H:i A ') }}</td>
    				<th>AGE</th>
    				<td>{{ $admission->patient->age }}</td>
    			</tr>
    			<tr>
    				<th>DATE OF DISCHARGE</th>
    				<td>{{ $discharge->created_at->format('jS M, Y H:i A ') }}</td>
    				<th>SEX</th>
    				<td>{{ $admission->patient->sex }}</td>
    			</tr>
    			<tr>
    				<th>TO COME AGAIN</th>
    				<td colspan="2">{{ $discharge->notes->to_come_again }}</td>
    			</tr>
    		</tbody>
    	</table>

    	<div class = "sections"><br/>
    		<h4>PRINCIPAL DIAGNOSIS</h4>
    		{{ ($discharge->notes->pricipal_diagnosis != null) ? $discharge->notes->pricipal_diagnosis : 'None recorded' }}
    	</div>

    	<div class = "sections"><br/>
    		<h4>OTHER DIAGNOSIS</h4>
    		{{ ($discharge->notes->other_diagnosis != null) ? $discharge->notes->other_diagnosis : 'None recorded' }}
    	</div>

    	<div class = "sections"><br/>
    		<h4>COMPLAINTS DIAGNOSIS</h4>
    		{{ ($discharge->notes->admission_complaints != null) ? $discharge->notes->admission_complaints : 'None recorded' }}
    	</div>

    	<div class = "sections"><br/>
    		<h4>INVESTIGATIONS AND HOSPITAL COURSES</h4>
    		{{ ($discharge->notes->investigations_courses != null) ? $discharge->notes->investigations_courses : 'None recorded' }}
    	</div>

    	<div class = "sections"><br/>
    		<h4>DISCHARGE CONDITIONS</h4>
    		{{ ($discharge->notes->discharge_condition != null) ? $discharge->notes->discharge_condition : 'None recorded' }}
    	</div>

    	<div class = "sections">
    		<h4>MEDICATION AT DISCHARGE</h4>
    		<table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Drug</th>
                        <th>Dosage & Duration</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prescriptions as $p)
                        <tr>
                            <td>#{{ $p->id }}</td>
                            <td>{{ $p->drugs->name }}</td>
                            <td>{{ $p->dose }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
    	</div>
        <br/><br/><br/>
        <table class="table table-hover" style="border: none !important;">
             <tbody style="border: none !important;">
               <tr style="border: none !important;">
                  <td style="border: none !important;" colspan="2"><u>{{ $discharge->doctor->profile->fullName}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                  <td style="border: none !important; padding-left: 25% !important;" colspan="2"><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></td>
               </tr>
               <tr style="border: none !important;">
                  <td style="border: none !important;" colspan="2"><strong>DOCTOR'S NAME AND SIGNATURE</strong></td>
                  <td style="border: none !important; padding-left: 25% !important;" colspan="2"><strong>DATE</strong></td>
               </tr>
             </tbody>
        </table>

      
</div>


<hr>