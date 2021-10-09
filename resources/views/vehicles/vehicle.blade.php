@extends('layouts.app')

@section('content')
    <div class="container">
		<div class="table-response">
			<table class="table table-bordered table-hover">
				<!-- 
					<tr class="warning">
					<tr class="info">
					<tr class="danger">
					<tr class="active">
				 -->
				<tbody><tr class="active">
					<th>Placa</th>
					<th>minutos</th>
					<th>Cantidad a pagar</th>
                    <th>Acción</th>
				</tr>
                <button class="btn btn-success">create register of cars</button>
                @isset($vehicles)
                    @foreach ($vehicles as $vehicles)
                        <tr>
                            <td>{{$vehicles->plaque}}</td>
                            <td>{{$vehicles->minutes}}</td>
                            <td>{{$vehicles->title}}</td>
                            <td><button class="btn btn-primery">update register</button><button class="btn btn-danger">delete register</button></td>
                        </tr>
                    @endforeach
                @endisset
				
			</tbody></table>
		</div>
	</div>
@endsection