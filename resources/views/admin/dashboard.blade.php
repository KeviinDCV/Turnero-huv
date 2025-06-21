@extends('layouts.admin')

@section('title', 'Dashboard')
@section('content')

                <div class="bg-white rounded-lg shadow-md p-4 md:p-6 max-w-7xl mx-auto space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Advisor Status Table -->
                <div class="bg-white rounded-lg shadow">
                    <div class="bg-hospital-blue text-white p-3 rounded-t-lg">
                        <div class="grid grid-cols-3 gap-4 text-sm font-semibold">
                            <div>ASESOR</div>
                            <div>DISPONIBILIDAD</div>
                            <div>ESTADO</div>
                        </div>
                    </div>
                    <div class="max-h-96 overflow-y-auto">
                        @foreach($advisorData as $advisor)
                        <div class="grid grid-cols-3 gap-4 p-3 text-sm border-b {{ $advisor['availability'] === 'CAJA CERRADA' ? 'bg-blue-50' : 'bg-white' }}">
                            <div>{{ $advisor['name'] }}</div>
                            <div class="{{ $advisor['availability'] === 'DISPONIBLE' ? 'text-hospital-blue' : 'text-blue-800' }}">
                                {{ $advisor['availability'] }}
                            </div>
                            <div class="{{ $advisor['status'] === 'DISPONIBLE' ? 'text-hospital-blue' : 'text-blue-800' }}">
                                {{ $advisor['status'] }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Service Summary -->
                <div class="bg-white rounded-lg shadow">
                    <div class="bg-hospital-blue text-white p-3 rounded-t-lg">
                        <div class="grid grid-cols-2 gap-4 text-sm font-semibold">
                            <div>SERVICIO</div>
                            <div>TERMINADOS</div>
                        </div>
                    </div>
                    <div>
                        @foreach($serviceData as $service)
                        <div class="grid grid-cols-2 gap-4 p-3 text-sm border-b bg-white">
                            <div>{{ $service['service'] }}</div>
                            <div class="text-hospital-blue">{{ $service['count'] }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Advisor Terminals -->
                <div class="bg-white rounded-lg shadow">
                    <div class="bg-hospital-blue text-white p-3 rounded-t-lg">
                        <div class="grid grid-cols-2 gap-4 text-sm font-semibold">
                            <div>ASESOR</div>
                            <div>TERMINADOS</div>
                        </div>
                    </div>
                    <div class="max-h-96 overflow-y-auto">
                        @foreach($advisorTerminals as $advisor)
                        <div class="grid grid-cols-2 gap-4 p-3 text-sm border-b bg-white">
                            <div>{{ $advisor['name'] }}</div>
                            <div class="text-hospital-blue">{{ $advisor['terminals'] }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Queue Information -->
                <div class="space-y-4">
                    <div class="bg-white rounded-lg shadow">
                        <div class="bg-hospital-blue text-white p-3 rounded-t-lg">
                            <div class="grid grid-cols-2 gap-4 text-sm font-semibold">
                                <div>SERVICIO</div>
                                <div>TURNOS AUSENTES</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow">
                        <div class="bg-hospital-blue text-white p-3 rounded-t-lg">
                            <div class="grid grid-cols-2 gap-4 text-sm font-semibold">
                                <div>SERVICIO</div>
                                <div>TURNOS EN COLA</div>
                            </div>
                        </div>
                        <div>
                            @foreach($queueData as $service)
                            <div class="grid grid-cols-2 gap-4 p-3 text-sm border-b bg-white">
                                <div>{{ $service['service'] }}</div>
                                <div class="text-hospital-blue">{{ $service['count'] }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow">
                        <div class="bg-hospital-blue text-white p-3 rounded-t-lg">
                            <div class="grid grid-cols-2 gap-4 text-sm font-semibold">
                                <div>CALIFICACIÓN</div>
                                <div>CONTEO</div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
@endsection
