# TaxiApp

## Authorization customers
App\Http\Controllers\Api\Customers\AuthController Authorization and registration of customers (implemented using JWT).

## Authorization drivers
App\Http\Controllers\Api\Drivers\AuthController Authorization of drivers, registration of a new driver is possible only from the admin panel (implemented using JWT).

## Authorization details
When authorizing drivers / customers, you need to use a phone number and password, and then enter a 6-digit number to confirm the phone number. This is implemented using the UNIFONIC service.
If a new client appears, you need to fill in the fields with your data during registration, including coordinates obtained from geolocation.

## CustomerController
App\Http\Controllers\Api\Customers\CustomerController
This Class implements:
- getting customer type (regular / service provider)
- getting a client profile
- editing client profile
- change status
- create an order
- get a list of drivers that are nearby
- disable notifications
- save the device token
- contact support (in whatsapp)



## DriverController
App\Http\Controllers\Api\Drivers\DriverController
This class implements:
- getting a driver profile
- editing driver profile
- change status
- get orders
- take the order
- save the device token
- contact support (in whatsapp)

## How does it work
When the driver/client becomes active in the application, a push comes from the client/driver who are no further than 5 km from his specified coordinates.
You can accept or reject the request.