//FUNCTION TO FILTER TABLE

function mySearch() {
  // Declaring variables 
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    } 
  }
}
//END OF FUNCTION TO FILTER TABLE



//TIME CALCULATION FUNCTIONALITY
document.querySelector("#start-time").addEventListener("change", myFunction);
document.querySelector("#end-time").addEventListener("change", myFunction);

function myFunction() {

  //value start
  var start = Date.parse($("input#start-time").val()); //get timestamp

  //value end
  var end = Date.parse($("input#end-time").val()); //get timestamp

  totalSecs = NaN;
  if (start < end ) 
  {
    totalSecs = Math.floor((end - start) / 1000); 

  hours=Math.floor((end - start)/1000/60/60); 
  temp=totalSecs%3600;
  mins=Math.floor(temp/60);
  days=Math.floor(totalSecs/3600);
  }
 else if(start > end && $("input#start-time").val() != undefined && $("input#end-time").val()!=undefined)
  {
    alert(days);
   alert("Ensure end time is later than start time. Try again");
   $("input#end-time").val('');
   $("input#start-time").val('');
   $("input#total-hours").val('');
 }



totalTime=hours+" hr(s)| "+mins+" min(s)["+days+" day(s)]"; //prints time spent on project

  $("#total-hours").val(totalTime);

}


//END OF TIME CALCULATION FUNCTIONALITY



