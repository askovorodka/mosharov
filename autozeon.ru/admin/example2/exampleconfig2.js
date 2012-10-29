//var hide_empty_list=true; //uncomment this line to hide empty selection lists
var disable_empty_list=true; //uncomment this line to disable empty selection lists

addListGroup("vehicles", "car-makers");

addOption("car-makers", "Select a maker", "", "", 1); //Empty starter option
addList("car-makers", "Toyota", "Toyota", "Toyota");
addList("car-makers", "Honda", "Honda", "Honda");
addList("car-makers", "Chrysler", "Chrysler", "Chrysler");

addOption("Toyota", "Select vehicle type", "", "", 1); //Empty starter option
addList("Toyota", "Cars", "car", "Toyota-Cars");
addList("Toyota", "SUVs/Van", "suv", "Toyota-SUVs/Van");
addList("Toyota", "Trucks", "truck", "Toyota-Trucks");

addOption("Toyota-Cars", "Select a model", "");
addOption("Toyota-Cars", "Avalon", "Avalon");
addOption("Toyota-Cars", "Camry", "Camry");
addOption("Toyota-Cars", "Celica", "Celica");
addOption("Toyota-Cars", "Corolla", "Corolla");
addOption("Toyota-Cars", "ECHO", "ECHO");

addOption("Toyota-SUVs/Van", "Select a model", "");
addOption("Toyota-SUVs/Van", "4Runner", "4Runner");
addOption("Toyota-SUVs/Van", "Highlander", "Highlander");
addOption("Toyota-SUVs/Van", "Land Cruiser", "Land Cruiser");
addOption("Toyota-SUVs/Van", "RAV4", "RAV4");

addOption("Toyota-Trucks", "Select a model", "");
addOption("Toyota-Trucks", "Tacoma", "Tacoma");
addOption("Toyota-Trucks", "Tundra", "Tundra", 1);

addOption("Honda", "Select vehicle type", "", "", 1); //Empty starter option
addList("Honda", "Cars", "car", "Honda-Cars");
addList("Honda", "SUVs/Van", "suv", "Honda-SUVs/Van");

addOption("Honda-Cars", "Select a model", "");
addOption("Honda-Cars", "Accord Sedan", "Accord Sedan");
addOption("Honda-Cars", "Accord Coupe", "Accord Coupe");
addOption("Honda-Cars", "Civic Sedan", "Civic Sedan");
addOption("Honda-Cars", "Civic Coupe", "Civic Coupe");
addOption("Honda-Cars", "Civic Hybrid", "Civic Hybrid");

addOption("Honda-SUVs/Van", "Select a model", "");
addOption("Honda-SUVs/Van", "CR-V", "CR-V");
addOption("Honda-SUVs/Van", "Pilot", "Pilot");
addOption("Honda-SUVs/Van", "Odyssey", "Odyssey", 1);

addOption("Chrysler", "Select vehicle type", "", "", 1); //Empty starter option
addList("Chrysler", "Cars", "car", "Chrysler-Cars");
addList("Chrysler", "SUVs/Van", "suv", "Chrysler-SUVs/Van");

addOption("Chrysler-Cars", "Select a model", "");
addOption("Chrysler-Cars", "300M", "300M");
addOption("Chrysler-Cars", "PT Cruiser", "PT Cruiser", 1);
addOption("Chrysler-Cars", "Concorde", "Concorde");
addOption("Chrysler-Cars", "Sebring Coupe", "Sebring Coupe");

addOption("Chrysler-SUVs/Van", "Select a model", "");
addOption("Chrysler-SUVs/Van", "Town & Country", "Town & Country");
addOption("Chrysler-SUVs/Van", "Voyager", "Voyager");
