@extends('layouts.app')

@section('content')
<div class="container">

    <div class="booking_showtime">
        <h3 class="showtime">Showtime</h3>
        <label for="" class="showtime_lable">{{ $showtime }}</label>
        <label for="" id="showtime_id" hidden>{{ $showtime_id }}</label>
        <input type="text" id="total_seats" value="{{ $total_seats }}" hidden>
    </div>

    <div class="center" style="margin-top: 100px">
        <div class="tickets">
            <div class="ticket-selector">
                <div class="head">
                    <div class="title">Movie Name</div>
                </div>
                <div class="seats">
                    <div class="status">
                        <div class="item">Available</div>
                        <div class="item">Booked</div>
                        <div class="item">Selected</div>
                    </div>
                    <div>
                        {{-- <input type="checkbox" name="tickets"/> --}}
                        <div class="referer-numbers">
                        </div>
                        <div class="all-seats">
                        </div>
                    </div>
                </div>
                <div class="timings">
                    <div class="dates">
                        <input type="radio" name="date" id="d1" checked />
                        <label for="d1" class="dates-item">
                            <div class="day">{{ $day }}</div>
                            <div class="date">{{ $date }}</div>
                        </label>
                    </div>
                </div>
            </div>
            <div class="price">
                <div class="total">
                    <span> <span class="count">0</span> Tickets </span>
                    <div>
                        <span class="amount">0</span>
                        <span class="currency"> LKR</span>
                    </div>
                </div>
                <button type="button" onclick="bookTickets()">Book</button>
            </div>
        </div>
    </div>

    <div class="booking_showtime" style="margin-top: 50px">
        <h3 class="showtime">If you want parking place</h3>
    </div>

    <div class="center">
        <div class="tickets">
            <div class="ticket-selector">
                <div class="head">
                    <div class="title">Parking</div>
                </div>
                
            </div>
            <div class="price">
                <div class="total">
                    <span> Number of available parking Tickets </span>
                    <div class="amount">10</div>
                </div>
                <button type="button">Book</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let seats = document.querySelector(".all-seats");
        let referer = document.querySelector(".referer-numbers");
        let total_seats = document.querySelector("#total_seats").value;
        const showtimeId = document.querySelector("#showtime_id").innerHTML;
        let ticketPrice = 0;
        const numberToLetter = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];

    
        fetch(`/get-showtime-details/${showtimeId}`)
            .then(response => response.json())
            .then(showtimeDetails => {
                ticketPrice = showtimeDetails.ticket_price;
                let bookedSeats = showtimeDetails.bookedSeats;

                let bookedMap = new Map();
                bookedSeats.forEach(seat => {
                    bookedMap.set(`row${seat.row}col${seat.col}`, true);
                });

                for (var i = 0; i < total_seats; i++) {
                    let row = Math.floor(i / 10) + 1;
                    let col = (i % 10) + 1;
                    let booked = bookedMap.has(`row${row}col${col}`) ? "booked" : "";
                    let disabled = booked ? "disabled" : "";
                    seats.insertAdjacentHTML(
                        "beforeend",
                        '<input type="checkbox" name="tickets" id="s' +
                        (i + 2) +
                        '" data-row="' + row + '" data-col="' + col + '" ' + disabled + ' /><label for="s' +
                        (i + 2) +
                        '" class="seat ' +
                        booked +
                        '"></label>'
                    );
                    if (row == col) {
                        let letter = numberToLetter[col - 1];
                        referer.insertAdjacentHTML(
                            "beforeend",
                            '<label for="s1" class="" data-row="' + letter + '">' + letter + '</label>'
                        );
                    }
                }

                let tickets = seats.querySelectorAll("input");
                tickets.forEach((ticket) => {
                    ticket.addEventListener("change", () => {
                        let count = document.querySelector(".count").innerHTML;
                        let amount = document.querySelector(".amount").innerHTML;
                        count = Number(count);
                        amount = Number(amount);

                        if (ticket.checked) {
                            count += 1;
                            amount += ticketPrice;
                        } else {
                            count -= 1;
                            amount -= ticketPrice;
                        }
                        document.querySelector(".count").innerHTML = count;
                        document.querySelector(".amount").innerHTML = amount;
                    });
                });

                document.querySelector('button[type="button"]').addEventListener('click', bookTickets);

                function bookTickets() {
                    let selectedSeats = [];

                    tickets.forEach((ticket) => {
                        if (ticket.checked) {
                            selectedSeats.push({
                                row: ticket.getAttribute('data-row'),
                                col: ticket.getAttribute('data-col'),
                                showtime: showtimeId
                            });
                        }
                    });

                    // Assuming you have a CSRF token meta tag in your blade file for Laravel
                    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    fetch('/book-tickets', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({
                            seats: selectedSeats
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Tickets booked successfully!');
                            window.location.reload();
                        } else {
                            alert('Failed to book tickets. Please try again.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
                }
            })
            .catch(error => console.error('Error fetching showtime details:', error));
    });
    </script>
    

@endsection
