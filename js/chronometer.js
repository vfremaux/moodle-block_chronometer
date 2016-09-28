var dd = 0;
var ss = 0;
var s = {$this->time->seconds};
var m = {$this->time->minutes};
var h = {$this->time->hours};
var j = {$this->time->days};
var chrono;
var started = 0;

function startChronometer() {
    if (started) return;
    runChronometer();
}

function runChronometer() {
    started = 1;

    if (m < 10){
         mt = '0' + m;
    } else {
       mt = m;
    }

    if (h < 10){
        ht = '0' + h;
    } else {
        ht = h;
    }

    if (s < 10){
        st = '0' + s;
    } else {
        st = s;
    }

    chronoId = document.getElementById(\"chronoDisplay\");
    chronoId.innerHTML = j + ' $daytag ' + ht + ':' + mt + ':' + st + ' / ' + dd;
    chronoIdSec = document.getElementById('chronoDisplaySec');
    chronoIdSec.innerHTML = ss + ' / ' + dd + ' sec';
    dd++;

    if (dd == 10){
        s = eval(s) + 1;
        ss++;
        dd = 0;
    }
    if (s == 60){
        s = 0;
        m++;
    }
    if (m == 60){
        m = 0;
        h++;
    }
    if (h == 24){
        h = 0;
        j++;
    }

    chrono = window.setTimeout('runChronometer()', 100);
}

function stopChronometer(){
    if (!started) return;
    window.clearTimeout(chrono);
    started = 0;
}

function resetChronometer(){
    if (started) return;
    s = 0;
    m = 0;
    j = 0;
    h = 0;
    ss = 0; 
    dd = 0;
    chronoId = document.getElementById('chrono-display');
    chronoId.innerHTML = \"0 $daytag 00:00:00 / 0\" ; 
    chronoIdSec = document.getElementById('chrono-display-sec');
    chronoIdSec.innerHTML = '00 / 0 sec';
}
