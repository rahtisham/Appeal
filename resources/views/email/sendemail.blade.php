<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<div class="row">
        <div class="fontStyle">
            <a href="#" class="brand-logo">
                <img class="" src="http://127.0.0.1:8000/AppealLab/images/logo1.png" alt="">
                <img class="" src="http://127.0.0.1:8000/AppealLab/images/logo-text1.png" alt="">
            </a>
        </div>
        <table class="table table-borderless">
            <thead>

            </thead>
            <tbody>
               @foreach($detail as $check)
                <tr>
                    <th scope="col">PRODUCT ID</th>
                    <td scope="col">{{ $check['productID']  }}</td>
                </tr>
                <tr>
                    <th scope="row">PRODUCT NAME</th>
                    <td>{{ $check['productName']  }}</td>
                </tr>
                <tr>
                    <th scope="row">EMAIL</th>
                    <td>{{ $check['userEmail']  }}</td>
                </tr>
                <tr>
                    <th scope="row">PUBLISHED STATUS</th>
                    <td colspan="2">{{ $check['publishedStatus']  }}</td>
                </tr>
                <tr>
                    <th scope="row">REASON</th>
                    <td colspan="2">{{ $check['reason']  }}</td>
                </tr>
                <tr>
                    <th scope="row">PRODUCT LINK</th>
                    <td colspan="2">{{ $check['productLink']  }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div><!--end of row-->
    {{-- End Email Template --}}

    <h1>Thank you</h1>

    <style>
        .fontStyle span
        {
            font-size: 16px;
            font-weight: 300;
        }
        th
        {
            text-align: left;
        }
        .table
        {
            margin-top: 50px;
        }
    </style>
