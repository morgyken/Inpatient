<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admission Letter</title>
</head>
<body>
    <style>
        body{
            text-align: center;
        }

        h1{
           padding-top: 20px;
           padding-bottom: 10px;
            font-size: 30px;
            text-decoration: underline;
        }

        .container{
            width: 595px;
            height: 840px;
            margin: 0 auto;
            border: 1px solid #ddd;
        }

        .linear{
            display: inline-block
        }

        .mb10{
            margin-bottom: 15px;
        }

        .hint{
            font-size: 14px;
            text-align: left;
            padding-left: 37px;
            padding-right: 37px;
        }

        .present{
            border-bottom: 2px dotted #000;
            display: inline-block;
        }
    </style>

    <div class="container">
    <h1>Admission Letter</h1>

    <div class="mb10">
        <div class="linear len-lg">
            <label for="">PATIENT(S) NAME</label>
            <span class="present" style="width: 200px;">{{ $patient->fullName }}</span>
        </div>
        <div class="linear len-md">
            <label for="">DATE</label>
            <span class="present" style="width: 134px;">{{ $today }}</span>
        </div>
    </div>

    <div class="mb10">
        <div class="linear len-md">
            <label for="">PATIENT(S) AGE</label>
            <span class="present" style="width: 90px;">{{ $patient->age }}</span>
        </div>
        <div class="linear len-md ">
            <label for="">SEX</label>
            <span class="present" style="width: 85px;">{{ $patient->sex }}</span>
        </div>
        <div class="linear len-md ">
            <label for="">ID NO</label>
            <span class="present" style="width: 133px;">{{ $patient->id_no }}</span>
        </div>
    </div>

    <div class="mb10">
        <div class="linear len-md">
            <label for="">DISTRICT</label>
            <span class="present" style="width: 112px;"></span>
        </div>
        <div class="linear len-md ">
            <label for="">LOCATION</label>
            <span class="present" style="width: 85px;"></span>
        </div>
        <div class="linear len-md ">
            <label for="">VILLAGE</label>
            <span class="present" style="width: 85px;"></span>
        </div>
    </div>

    <div class="mb10">
        <div class="linear len-xl">
            <label for="">NEXT OF KIN</label>

            <span class="present" style="width: 420px;">{{ $patient->nok->fullName }}</span>
        </div>
    </div>

    <div class="mb10">
        <div class="linear len-xl">
            <label for="">RELATIONSHIP</label>
            <span class="present" style="width: 407px;"></span>
        </div>
    </div>

    <div class="mb10">
        <div class="linear len-xl">
            <label for="">PATIENT(S) ADDRESS</label>
            <span class="present" style="width: 360px;"></span>
        </div>
    </div>

    <div class="mb10">
        <div class="linear len-xl">
            <label for="">TELEPHONE NUMBERS</label>
            <span class="present" style="width: 348px;"></span>
        </div>
    </div>

    <p class="hint">I Hereby Agree/Disagree to be admitted in the above hospital as per the doctor’s Advice. I also consent to any surgical interventions under Anesthesia as per the doctor’s instructions.</p>

    <div class="mb10">
        <div class="linear len-xl">
            <label for="">PATIENT(S) SIGNATURE</label>
            <span class="present" style="width: 344px;"></span>
        </div>
    </div>

    <div class="mb10">
        <div class="linear len-xl">
            <label for="">GUARDIANS SIGNATURE (INCASE OF A MINOR)</label>
            <span class="present" style="width: 164px;"></span>
        </div>
    </div>

    <p class="hint">An Admission deposit of 5,000 for NHIF and ksh 10,000 for cash patients is mandatory on admission.</p>
    
    <div class="mb10">
        <div class="linear len-lg">
            <label for="">Amount Paid</label>
            <span class="present" style="width: 183px;"></span>
        </div>
        <div class="linear len-md">
            <label for="">Patients sign</label>
            <span class="present" style="width: 164px;"></span>
        </div>
    </div>

    <div class="mb10">
        <div class="linear len-lg">
            <label for="">Receiving clerk’s signature</label>
            <span class="present" style="width: 136px;"></span>
        </div>
        <div class="linear len-md">
            <label for="">Name</label>
            <span class="present" style="width: 164px;"></span>
        </div>
    </div>

    <p class="hint">In case you are allergic to any drugs, types of food or anything that has been diagnosed as being allergic to you please indicate below.</p>
    
    <div class="hint">
        <div class="mb10">.....................................................................................................................................................</div>
        <div class="mb10">................................................................................................................</div>
    </div>
    
    <p class="hint">The above information is to the best of my knowledge true and correct and does not require any alterations whatsoever.</p>

    <div>
        <div class="linear len-lg">
            <label for="">Patients Signature</label>
            <span class="present" style="width: 104px;"></span>
        </div>
        <div class="linear len-md">
            <label for="">Admitting Doctor’s signature</label>
            <span class="present" style="width: 99px;"></span>
        </div>
    </div>

    <p class="hint"><b>Adhere to the terms and conditions of the contract.</b></p>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>