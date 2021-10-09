@extends('layouts.app')
@section('content')
    <h1 class="text-center mt-l">Agregar plaque</h1>
    <div class="container mt-sl">
        <form action="{{ Route('create')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <strong>Tipo de vehículo</strong>
                        <select name="category"  class="form-control" value="{{old('typevehicle')}}">
                            <option selected value="">Selecciona el tipo de vehículo</option>
                            <option value="residente">Residente</option>
                            <option value="no residente">No Residente</option>
                            <option value="vehiculo oficial">vehiculo oficial</option>
                        </select>            
                        @if($errors->has('typevehicle'))
                            <strong class="text-danger">{{ $errors->first('typevehicle')}}</strong>
                        @endif
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <strong>Placa</strong>
                        <input value="{{ old('plaque')}}" type="text" name="plaque" class="form-control" placeholder="Placa">
                        @if($errors->has('plaque'))
                        <strong class="text-danger">{{ $errors->first('plaque')}}</strong>
                        @endif
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <strong>fecha inicial</strong>
                        <input name="solution" class="form-control" type="datetime">{{ old('dateinit')}}</textarea>
                        @if($errors->has('dateinit'))
                        <strong class="text-danger">{{ $errors->first('dateinit')}}</strong>
                        @endif
                    </div>
                </div>

                <div class="col-md-12 text-center btn-yellow-dark">
                    <button class="btn">Enviar</button>
                </div>
            </div>
        </form>
    </div>
@endsection