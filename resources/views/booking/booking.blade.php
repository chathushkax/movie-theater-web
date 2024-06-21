@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="booking_showtime">
            <h3 class="showtime">Showtime</h3>
            <label for="" class="showtime_lable">10.30</label>
        </div>

        <div class="center"  style="margin-top: 100px">
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
                        <div class="all-seats">
                            <input type="checkbox" name="tickets" id="s1" />
                            <label for="s1" class="seat booked"></label>
                        </div>
                    </div>
                    <div class="timings">
                        <div class="dates">
                            <input type="radio" name="date" id="d1" checked />
                            <label for="d1" class="dates-item">
                                <div class="day">Sun</div>
                                <div class="date">11</div>
                            </label>
                            <input type="radio" id="d2" name="date" />
                            <label class="dates-item" for="d2">
                                <div class="day">Mon</div>
                                <div class="date">12</div>
                            </label>
                            <input type="radio" id="d3" name="date" />
                            <label class="dates-item" for="d3">
                                <div class="day">Tue</div>
                                <div class="date">13</div>
                            </label>
                            <input type="radio" id="d4" name="date" />
                            <label class="dates-item" for="d4">
                                <div class="day">Wed</div>
                                <div class="date">14</div>
                            </label>
                            <input type="radio" id="d5" name="date" />
                            <label class="dates-item" for="d5">
                                <div class="day">Thu</div>
                                <div class="date">15</div>
                            </label>
                            <input type="radio" id="d6" name="date" />
                            <label class="dates-item" for="d6">
                                <div class="day">Fri</div>
                                <div class="date">16</div>
                            </label>
                            <input type="radio" id="d7" name="date" />
                            <label class="dates-item" for="d7">
                                <div class="day">Sat</div>
                                <div class="date">17</div>
                            </label>
                        </div>
                        {{-- <div class="times">
                            <input type="radio" name="time" id="t1" checked />
                            <label for="t1" class="time">11:00</label>
                            <input type="radio" id="t2" name="time" />
                            <label for="t2" class="time"> 14:30 </label>
                            <input type="radio" id="t3" name="time" />
                            <label for="t3" class="time"> 18:00 </label>
                            <input type="radio" id="t4" name="time" />
                            <label for="t4" class="time"> 21:30 </label>
                        </div> --}}
                    </div>
                </div>
                <div class="price">
                    <div class="total">
                        <span> <span class="count">0</span> Tickets </span>
                        <div class="amount">0</div>
                    </div>
                    <button type="button">Book</button>
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
        let seats = document.querySelector(".all-seats");
        for (var i = 0; i < 59; i++) {
            let randint = Math.floor(Math.random() * 2);
            let booked = randint === 1 ? "booked" : "";
            seats.insertAdjacentHTML(
                "beforeend",
                '<input type="checkbox" name="tickets" id="s' +
                (i + 2) +
                '" /><label for="s' +
                (i + 2) +
                '" class="seat ' +
                booked +
                '"></label>'
            );
        }

        let tickets = seats.querySelectorAll("input");
        tickets.forEach((ticket) => {
            ticket.addEventListener("change", () => {
                let amount = document.querySelector(".amount").innerHTML;
                let count = document.querySelector(".count").innerHTML;
                amount = Number(amount);
                count = Number(count);

                if (ticket.checked) {
                    count += 1;
                    amount += 200;
                } else {
                    count -= 1;
                    amount -= 200;
                }
                document.querySelector(".amount").innerHTML = amount;
                document.querySelector(".count").innerHTML = count;
            });
        });
    </script>
@endsection
