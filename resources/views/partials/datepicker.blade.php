{{-- <div class="datepicker-custom">
    <div class="row teal darken-2 white-text center-align">
        <div class="col s12 m12 l12">
            <h6>Tuesday</h6>
        </div>
    </div>
    <div class="row teal white-text center-align">
        <div class="col s12 m12 l12">
            <h4>12th July 2016 - 12:00AM</h4>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m6">

            @php
                $n=1;
            @endphp
            @for ($w=0; $w < 5 ; $w++)
                @for($d=0; $d < 7; $d++)
                    {{$n}}
                    @php
                        $n++;
                    @endphp
                @endfor
                <br />
            @endfor
        </div>
        <div class="col s12 m6">

        </div>
    </div>
</div> --}}
<a class="btn c-datepicker-btn">Open Picker</a>
<pre id="events"></pre>
<script>
// import MaterialDateTimePicker from 'material-datetime-picker';
$(document).ready(function(){
    var picker = new MaterialDatetimePicker({})
      .on('submit', function(d) {
        output.innerText = d;
      });

    var el = document.querySelector('.c-datepicker-btn');
    el.addEventListener('click', function() {
      picker.open();
    }, false);
});
</script>
