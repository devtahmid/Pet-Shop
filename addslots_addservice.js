var currentSlotIndex = 1;
function addSlot(e) {
  currentSlotIndex += 1;
  var divSlot = document.createElement('div');
  console.log(divSlot);
  var labelStartTime = document.createElement('label');
  labelStartTime.htmlFor = currentSlotIndex + "#time1";
  labelStartTime.innerText = "Start Time : ";
  var startTimeInput = document.createElement('input');
  startTimeInput.type = "time";
  startTimeInput.id = currentSlotIndex + "#time1";
  startTimeInput.name = "TIME[]";
  startTimeInput.required = true;

  var labelEndTime = document.createElement('label');
  labelEndTime.htmlFor = currentSlotIndex + "#time2"; //copilot
  labelEndTime.innerText = "End Time : ";  //copilot
  var endTimeInput = document.createElement('input');
  endTimeInput.type = "time";
  endTimeInput.id = currentSlotIndex + "#time2";
  endTimeInput.name = "TIME[]";
  endTimeInput.required = true;

  var h4 = document.createElement('h4');
  h4.innerText = "Select days of the week (atleast one required):";

  var checkbox1 = document.createElement('input');
  checkbox1.type = "checkbox";
  checkbox1.id = currentSlotIndex + "#sunday";
  checkbox1.name = "DAY[]";
  checkbox1.value = currentSlotIndex + "#SUNDAY";
  checkbox1.checked = true;
  var chheckbox1label = document.createElement('label');
  chheckbox1label.htmlFor = currentSlotIndex + "#sunday";
  chheckbox1label.innerText = "Sunday";

  var checkbox2 = document.createElement('input');
  checkbox2.type = "checkbox";     //copilot
  checkbox2.id = currentSlotIndex + "#monday"; //copilot
  checkbox2.name = "DAY[]"; //copilot
  checkbox2.value = currentSlotIndex + "#MONDAY"; //copilot
  checkbox2.checked = false;  //copilot
  var chheckbox2label = document.createElement('label'); //copilot
  chheckbox2label.htmlFor = currentSlotIndex + "#monday"; //copilot
  chheckbox2label.innerText = "Monday";

  var checkbox3 = document.createElement('input');
  checkbox3.type = "checkbox";
  checkbox3.id = currentSlotIndex + "#tuesday";
  checkbox3.name = "DAY[]";
  checkbox3.value = currentSlotIndex + "#TUESDAY";
  checkbox3.checked = false;
  var chheckbox3label = document.createElement('label');
  chheckbox3label.htmlFor = currentSlotIndex + "#tuesday";
  chheckbox3label.innerText = "Tuesday";

  var checkbox4 = document.createElement('input');
  checkbox4.type = "checkbox";
  checkbox4.id = currentSlotIndex + "#wednesday";
  checkbox4.name = "DAY[]";
  checkbox4.value = currentSlotIndex + "#WEDNESDAY";
  checkbox4.checked = false;
  var chheckbox4label = document.createElement('label');
  chheckbox4label.htmlFor = currentSlotIndex + "#wednesday";
  chheckbox4label.innerText = "Wednesday";

  var checkbox5 = document.createElement('input');
  checkbox5.type = "checkbox";
  checkbox5.id = currentSlotIndex + "#thursday";
  checkbox5.name = "DAY[]";
  checkbox5.value = currentSlotIndex + "#THURSDAY";
  checkbox5.checked = false;
  var chheckbox5label = document.createElement('label');
  chheckbox5label.htmlFor = currentSlotIndex + "#thursday";
  chheckbox5label.innerText = "Thursday";

  var tabspace = document.createElement('div');
  tabspace.innerHTML = "    ";

  divSlot.appendChild(labelStartTime);
  divSlot.appendChild(startTimeInput);
  /*   divSlot.appendChild(tabspace) */
  divSlot.appendChild(labelEndTime);
  divSlot.appendChild(endTimeInput);
  divSlot.appendChild(h4);

  divSlot.appendChild(checkbox1);
  divSlot.appendChild(chheckbox1label);
  /*   divSlot.appendChild(tabspace) */
  divSlot.appendChild(checkbox2);
  divSlot.appendChild(chheckbox2label);
  /*   divSlot.appendChild(tabspace) */
  divSlot.appendChild(checkbox3);
  divSlot.appendChild(chheckbox3label);
  /*  divSlot.appendChild(tabspace) */
  divSlot.appendChild(checkbox4);
  divSlot.appendChild(chheckbox4label);
  /* divSlot.appendChild(tabspace) */
  divSlot.appendChild(checkbox5);
  divSlot.appendChild(chheckbox5label);

  document.getElementById('slots').appendChild(divSlot);
  var br = document.createElement('br');
  document.getElementById('slots').appendChild(br);
}

document.getElementById('addSlotButton').addEventListener('click', addSlot);