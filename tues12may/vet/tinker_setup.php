<?php

//PHP data to past into Tinker to seed DB

$owner = new Owner();
$owner->first_name = "Bilblo";
$owner->last_name = "Baggins";
$owner->telephone = 11122233344;
$owner->address_1 = "123 Wizard Lane";
$owner->address_2 = "P.O. Box 78";
$owner->town = "Hobbiton";
$owner->postcode = "NA";

$owner = new Owner();
$owner->first_name = "Joe";
$owner->last_name = "Exotic";
$owner->telephone = 14125232344;
$owner->address_1 = "123 Weird Farm Rd";
$owner->address_2 = "";
$owner->town = "Oklahoma";
$owner->postcode = "33789";

$owner->save();

$owner = new Owner();
$owner->first_name = "Carole";
$owner->last_name = "Baskin";
$owner->telephone = 04125332354;
$owner->address_1 = "456 Shelter Place";
$owner->address_2 = "Big Cat Reserve";
$owner->town = "Florida";
$owner->postcode = "53789";

$owner = new Owner();
$owner->first_name = "Cult";
$owner->last_name = "Weirdo";
$owner->telephone = 90125332361;
$owner->address_1 = "8893 Cult Place Zoo";
$owner->address_2 = "";
$owner->town = "South Carolina";
$owner->postcode = "90210";
$owner->save();

$owner = new Owner();
$owner->first_name = "Luke";
$owner->last_name = "Skywalker";
$owner->telephone = 1912553236109;
$owner->address_1 = "55 A Galaxy";
$owner->address_2 = "Far Far Away";
$owner->town = "Tattonine";
$owner->postcode = "999999";
$owner->save();


// Queries

// town = Bristol
$results = Owner::where('town','Bristol')->get();

// Order alphabetically by last names
$results = Owner::orderBy('last_name', 'desc')->get();

// Get back just the owners who have a telephone number starting with 0117
$results = Owner::where('telephone', 'like', '559%')->get();


// Seeding

// User
$user = new User();
$user->name = "Nik Osvalds";
$user->email = "nosvalds@gmail.com";
$user->password = Hash::make("hello");
$user->save();