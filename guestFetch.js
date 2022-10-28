//Add XLSX Feature
const XLSX = require("xlsx");

//Read the file into the Memory
const workbook = XLSX.readFile("guest.xlsx");
const worksheet = workbook.Sheets["Sheet1"];
const arrGuest = XLSX.utils.sheet_to_json(worksheet);

//Send Data to PHP
const toPassPhp = (arr) =>{
return (`Hellow ${arr.Firsname} ${arr.Lastname}!`);
}

//Fetch data from excel
const fetchGuest = () =>{
    for(let toEntry of arrGuest){
        if(toEntry["success"] > 0){
            continue;
        }toEntry.success = 1;
        return toPassPhp(toEntry);
    }
}
fetchGuest();
//Update Excel File
XLSX.utils.sheet_add_json(worksheet, arrGuest)
XLSX.writeFile(workbook, "guest.xlsx");
