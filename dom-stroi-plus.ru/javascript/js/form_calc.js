function chek1(n){

for (var i=0;i<3;i++){
document.getElementById('select'+i).disabled = true;

if (i==n) {
document.getElementById('select'+n).disabled = false;
}
}}

function franton(){
document.getElementById('fr1').disabled = false;
}
function nofranton(){
document.getElementById('fr1').disabled = true;
}
