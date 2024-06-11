@extends('Admin.layouts.master')

@section('show.rooms')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Reservation Details</h1>

    <!-- Details -->
    <div id="print-content">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Reservation Bill Check</h6>
                <div>
                    <a class="btn btn-outline-primary" href="{{ route('reservation.index') }}">Back</a>
                    <button class="btn btn-outline-info" onclick="printBill()">Print</button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4><strong>Reservation Details</strong></h4>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>User Name</th>
                                    <td>{{ $reservation->user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Reservation Code</th>
                                    <td>{{ $reservation->code }}</td>
                                </tr>
                                <tr>
                                    <th>Room ID</th>
                                    <td>{{ $reservation->room_id }}</td>
                                </tr>
                                <tr>
                                    <th>Reservation Start Date</th>
                                    <td>{{ $reservation->start_date }}</td>
                                </tr>
                                <tr>
                                    <th>Reservation End Date</th>
                                    <td>{{ $reservation->end_date }}</td>
                                </tr>
                                <tr>
                                    <th>Staying Nights</th>
                                    <td>{{ $stayingNights }}</td>
                                </tr>
                                <tr>
                                    <th>Number of Guests</th>
                                    <td>{{ $reservation->guestNumber }}</td>
                                </tr>
                                <tr>
                                    <th>Total Price</th>
                                    <td>{{ $reservation->totalPrice }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h4><strong>Bill Details</strong></h4>
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Room Type</th>
                                    <th>Room Type Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $reservation->room->roomType->name }}</td>
                                    <td>{{ $reservation->room->roomType->price }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5 class="mt-4"><strong>Room Services</strong></h5>
                        <table class="table table-bordered mt-3">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Room Service</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($services as $service)
                                    <tr>
                                        <td>{{ $service['name'] }}</td>
                                        <td>{{ $service['price'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <table class="table table-bordered mt-5">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Sum</th>
                                    <th>{{ $reservation->room->price }}</th>
                                </tr>
                                <tr>
                                    <th>Total = ({{ $reservation->room->price }}) * ({{ $stayingNights }})</th>
                                    <th>{{ $reservation->totalPrice }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function printBill() {
            var printContents = document.getElementById('print-content').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
@endsection
