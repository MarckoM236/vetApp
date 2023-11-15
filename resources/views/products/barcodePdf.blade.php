<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>pdf</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    
    <style>
        /*Page break style*/
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    @if(isset($result))
        <div class="container">
            <table class="table" id="barcode">
                <thead>
                </thead>
                <tbody>
                    @php $pag = 0; @endphp
                @for ($j=0; $j < count($result); $j += 2)
                    <tr>
                    @for ($i = $j; $i < ($j+2); $i++)
                        @if($i >= count($result) )
                        @break
                        @endif
                        <td>
                        <div class="card text-center p-3" style="width: 18rem;">
                            <img class="card-img-top" src="data:image/png;base64,{{$barcode->getBarcodePNG($result[$i]->code, 'C128A')}}" alt="barcode" style="right: 120px; height:100px;">
                            <p class="mt-1"><strong>{{$result[$i]->code}}</strong></p>
                            <div class="card-body">
                            <p class="card-text">{{$result[$i]->name}}</p>
                            </div>
                        </div>
                        </td>
                    @endfor
                    </tr>
                    <!-- generates 4 lines with barcodes and skips to the next page -->
                    @php $pag++;@endphp
                    @if($pag == 4)
                        <div class="page-break"></div>
                    @endif
                    <!-- end skips -->
                @endfor    
                </tbody>
            </table>
        </div> 
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>