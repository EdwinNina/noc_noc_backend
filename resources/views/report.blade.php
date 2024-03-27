<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>NOCAPP REPORT</title>
</head>
<body>
    <header style="display:flex;justify-content: center;align-items: center">
        <h1 style="font-size: 15px">NOCAPP</h1>
        <h3 style="font-size: 10px">REPORTE DE TAREAS DE LA APLICACION</h3>
    </header>
    <main>
        <h4>Resultados del rango de fecha de {{$dateFrom}} a {{$dateTo}}</h4>
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Titulo</th>
                    <th>Descripcion</th>
                    <th>Empleado</th>
                    <th>Estado</th>
                    <th>Fecha de Inicio</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->name }}</td>
                        @switch($item->status)
                            @case(1)
                            <td>Pendiente</td>
                            @break
                            @case(2)
                            <td>Progreso</td>
                            @break
                            @case(3)
                            <td>Blockeado</td>
                            @break
                            @case(4)
                            <td>Completado</td>
                            @break
                            @default
                        @endswitch
                    </tr>
                    <tr>{{ $item->created_at }}</tr>
                @endforeach
            </tbody>
        </table>
    </main>
</body>
</html>
