// auto-refresh de la timeline
function timedRefreshed(timeoutPeriod){
setTimeOut("location.reload(true);", timeoutPeriod);
}

window.onload = timedRefreshed(5000);
