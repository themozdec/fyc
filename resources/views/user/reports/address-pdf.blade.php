<!DOCTYPE html>
<html lang="es_MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>EncuentraTuCódigo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    
</head>
<body>

    <div class="container mt-5">
        <div class="col">
        <h2 class="text-center">EncuentraTuCódigo</h2></div>
        <div class="col">
         <img style="width: 100px;height: 80px;" alt="ups" src="https://fyc.store-line.stormonlinegroup.com/assets/images/logo-dark-sm.png"></img>
        </div>
        <div class="col">
        <h5 class="text-right">Fecha: {{$diaActual = \Carbon\Carbon::now()->isoFormat('dddd D \d\e MMMM \d\e\l Y')}}</h5>    
        </div> 
        <div class="col">
        <h3 class="text-left">Direcciones</h3>    
        </div>
        </div>
        <div class="d-flex justify-content-end mb-4">
           
        </div>
        <table class="table table-bordered mb-5">
            <thead>
                <tr class="table-danger">
                    <th scope="col">Dirección</th>
                    <th scope="col">Ciudad</th>
                    <th scope="col">Código Postal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($address ?? '' as $data)
                <tr>
                    <td>{{ $data->address }}</td>
                    <td>{{ $data->city }}</td>
                    <td>{{ $data->pincode }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
   
</body>
</html>