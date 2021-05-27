###
@api {post} /api/auth/drivers/login Start login
@apiName Login
@apiDescription Start login. Send SMS
@apiGroup Auth
@apiVersion 0.1.0

@apiParam {Integer} phone Required

@apiSuccessExample Success-Response:
HTTP/1.1 200 OK
{
    "success": true,
    "message": "We have sent you verification SMS"
}

@apiErrorExample Invalid data (phone is null or must be integer):
HTTP/1.1 422 Error
{
    "message": "The given data was invalid.",
    "errors": {
        "phone": [
	     "The phone must be an integer",
		 "The phone field is required",
		 "This phone is invalid"
        ]
    }
}
###

###
@api {post} /api/auth/drivers/verify Sending code
@apiName Sending code
@apiDescription Sending code. Available for guest
@apiGroup Auth
@apiVersion 0.1.0

@apiParam {Integer} code Required
@apiParam {Integer} phone Required
@apiParam {String} deviceToken
@apiParam {String} type

@apiSuccessExample Success-Response:
HTTP/1.1 200 OK
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODA3NVwvYXBpXC9hdXRoXC9sb2dpbiIsImlhdCI6MTU3MTg0MzU3MywiZXhwIjoxNTcxODQ3MTczLCJuYmYiOjE1NzE4NDM1NzMsImp0aSI6IkgxTmpRZElPMkswdmt5Q1AiLCJzdWIiOjcsInBydiI6Ijg4NGZmZTU4MmQ3YWYwNTI0Y2U3YmI0MzFlY2M5NTU4Mjc0NzA4ZWYifQ.k7mHSxk1oiZ22ZAIeM8_Soj4LVkE4mhAWo9MlfURk_Y",
    "driverId": 2
    "expires_in": 3600
    "token_type": "bearer"
}

@apiErrorExample Invalid data (code has expired):
HTTP/1.1 422 Error
{
    "message": "The given data was invalid.",
    "errors": {
        "code": [
            "Code has expired"
        ]
    }
}

@apiErrorExample Invalid data:
HTTP/1.1 422 Error
{
    "message": "The given data was invalid.",
    "errors": {
        "code": [
            "The code must be an integer"
            "Invalid code"
        ]
    }
}
###

###
@api {get} /api/driver/get-profile Get info drivers
@apiName Get info drivers
@apiDescription Get info drivers. Send driver profile
@apiGroup Auth
@apiVersion 0.1.0

@apiParam {Integer} driverId Required
@apiHeader {String} Authorization Bearer token

@apiSuccessExample Success-Response:
HTTP/1.1 200 OK
{
    "driverId": 2,
    "first_name": "Serg1",
    "last_name": "Zoer1",
    "phone": "223456789",
    "status": true
}

@apiErrorExample Invalid data:
HTTP/1.1 422 Error
{
    "message": "The given data was invalid.",
    "errors": {
        "driverId": [
	     "The driverId must be an integer",
		 "The driverId field is required"
		 "The driver does not exist."
        ]
    }
###

###
@api {put} /api/driver/edit-profile Edit info drivers
@apiName Edit info drivers
@apiDescription Edit info drivers. Send driver profile
@apiGroup Auth
@apiVersion 0.1.0

@apiParam {Integer} driverId  Required
@apiParam {string} first_name driver
@apiParam {string} last_name driver
@apiHeader {String} Authorization Bearer token

@apiSuccessExample Success-Response:
HTTP/1.1 200 OK
{
    "driverId": 8,
    "first_name": John,
    "last_name":  Doe,
    "phone": 380973614352,
}

@apiErrorExample Invalid data:
HTTP/1.1 422 Error
{
    "message": "The given data was invalid.",
    "errors": {
        "driverId": [
	     "The driverId must be an integer",
		 "The driverId field is required"
		 "The driver does not exist."
        ]
    }
}
###

###
@api {put} /api/driver/push-notifications Driver receiving push notifications
@apiName Driver receiving push notifications
@apiDescription Set drivers status. Driver receiving push notifications
@apiGroup Auth
@apiVersion 0.1.0

@apiParam {Integer} driverId Required
@apiParam {bool} status Required
@apiHeader {String} Authorization Bearer token

@apiSuccessExample Success-Response:
HTTP/1.1 200 OK
{
    "driverId": 2,
    "status": "true"
}

@apiErrorExample Invalid data:
HTTP/1.1 422 Error
{
    "message": "The given data was invalid.",
    "errors": {
        "status": [
	     "The status must be an boolian",
		 "The status field is required"
        ]
    }
}

@apiErrorExample Invalid data:
HTTP/1.1 422 Error
{
    "message": "The given data was invalid.",
    "errors": {
        "driverId": [
	     "The driverId must be an integer",
		 "The driverId field is required"
		 "The driver does not exist."
        ]
    }
}
###


###
@api {get} /api/driver/orders Get all orders
@apiName Get all orders
@apiDescription Get all orders
@apiGroup Auth
@apiVersion 0.1.0

@apiParam {Integer} driverId Required
@apiParam {Float} longitudeDriver Required
@apiParam {Float} latitudeDriver Required
@apiHeader {String} Authorization Bearer token

@apiSuccessExample Success-Response:
HTTP/1.1 200 OK
{
    "first_name": John
    "last_name": Doe
    "address": Oak Ave, 5,
    "phone": 4523356987,
    "longitude": 47.12343,
    "latitude": 89.5675,
    "remoteness": 4,
	"order": 7,
}
{
    "first_name": John
    "last_name": Doe
    "address": Oak Ave, 69,
    "phone": 45233569345,
    "longitude": 42.12111,
    "latitude": 84.6575,
	"order": 8,
}
{
    "first_name": John,
    "last_name": Doe,
    "address": Oak Ave, 123,
    "phone": 4523351234,
    "longitude": 46.12113,
    "latitude": 86.5234,
	"order": 9,
}
...
###

###
@api {put} /api/driver/order-confirm Order confirmation
@apiName Order confirmation
@apiDescription Order confirmation
@apiGroup Auth
@apiVersion 0.1.0

@apiParam {String} driverId Required
@apiParam {Integer} order Required
@apiHeader {String} Authorization Bearer token

@apiSuccessExample Success-Response:
HTTP/1.1 200 OK
{
    "driverId": 8,
	"order": 7,
    "status": true
}

@apiErrorExample Invalid data:
HTTP/1.1 401 Error
{
    "message": "The given data was invalid.",
    "errors": {
        "driverId": [
	     "The order must be an integer"
		 "The order field is required"
		 "The order does not exist"
		 "The order is already taken by another driver"
        ]
    }
}
###

###
@api {post} /api/driver/refresh-token Refresh driver token
@apiName Refresh driver token
@apiDescription Refresh driver token
@apiGroup Auth
@apiVersion 0.1.0

@apiHeader {String} Authorization Bearer token

@apiSuccessExample Success-Response:
HTTP/1.1 200 OK

@apiSuccessExample Success-Response:
HTTP/1.1 200 OK
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvYXBpXC9jdXN0b21lclwvcmVmcmVzaC10b2tlbiIsImlhdCI6MTYwODkwNTg0OCwiZXhwIjoxNjE2Nzg5ODY2LCJuYmYiOjE2MDg5MDU4NjYsImp0aSI6IjRCbTNnOGNGS0ZIM1JyeWQiLCJzdWIiOjEsInBydiI6IjFkMGEwMjBhY2Y1YzRiNmM0OTc5ODlkZjFhYmYwZmJkNGU4YzhkNjMifQ.Lcih9OYTQ5c0dxhpiWgOXrcfp1_rE9CZUWGdklJOhhE",
    "token_type": "bearer",
    "driverId": 1,
    "expires_in": "30 minutes"
}
###

###
@api {post} /api/driver/devices Push-token to Firebase
@apiName Push-token to Firebase
@apiDescription Push-token to Firebase
@apiGroup Auth

@apiHeader {String} Authorization Bearer token
@apiParam {String} deviceToken
@apiParam {String} type

HTTP/1.1 200 OK
{
    "success": true
}

HTTP/1.1 401 Error
{
    "message": "Unauthenticated."
}
###

###
@api {post} /api/driver/logout Logout from application
@apiName Logout from application
@apiDescription Logout from application
@apiGroup Auth

@apiHeader {String} Authorization Bearer token
@apiParam {String} deviceToken

HTTP/1.1 200 OK
{
    "message": "Successfully logged out"
}
###

###
@api {get} /api/driver/support Get support
@apiName Get support
@apiDescription Get support
@apiGroup Auth
@apiVersion 0.1.0

@apiHeader {String} Authorization Bearer token

@apiSuccessExample Success-Response:
HTTP/1.1 200 OK
{
    "whatsapp": "https://api.whatsapp.com/send/?phone=380951101619&text&app_absent=0"
}
###

###
---------------------------------------------------------------------------CUSTOMER --------------------------------------------------------------------------------
###

###
@api {post} /api/auth/customers/login Start login
@apiName Login
@apiDescription Start login. Send SMS
@apiGroup Auth
@apiVersion 0.1.0

@apiParam {Integer} phone Required

@apiSuccessExample Success-Response:
HTTP/1.1 200 OK
{
    "success": true,
    "message": "We have sent you verification SMS"
}

@apiErrorExample Invalid data (phone is null or must be integer):
HTTP/1.1 422 Error
{
    "message": "The given data was invalid.",
    "errors": {
        "phone": [
	     "The phone must be an integer",
		 "The phone field is required",
		 "This phone is invalid"
        ]
    }
}
###

###
@api {post} /api/auth/customers/registration Sign Up
@apiName Sign Up
@apiDescription Sign Up. Send SMS
@apiGroup Auth
@apiVersion 0.1.0

@apiParam {Integer} phone Required

@apiSuccessExample Success-Response:
HTTP/1.1 200 OK
{
    "success": true,
    "message": "We have sent you verification SMS"
}

@apiErrorExample Invalid data (phone is null or must be integer):
HTTP/1.1 422 Error
{
    "message": "The given data was invalid.",
    "errors": {
        "phone": [
	     "The phone must be an integer",
		 "The phone field is required",
		 "This number already exist",
		 "This phone is invalid"
        ]
    }
}
###

###
@api {post} /api/auth/customers/verify Sending code
@apiName Sending code
@apiDescription Sending code. Available for guest
@apiGroup Auth
@apiVersion 0.1.0

@apiParam {Integer} code Required
@apiParam {String} deviceToken
@apiParam {String} type

@apiSuccessExample Success-Response:
HTTP/1.1 200 OK
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvYXBpXC9hdXRoXC9jdXN0b21lcnNcL3ZlcmlmeS1hbmQtbG9naW4iLCJpYXQiOjE2MDg4NzcxNTYsImV4cCI6MTYwODg4MDc1NiwibmJmIjoxNjA4ODc3MTU2LCJqdGkiOiI4bWJOMGM0QVdYT2MxRjhtIiwic3ViIjo1LCJwcnYiOiIxZDBhMDIwYWNmNWM0YjZjNDk3OTg5ZGYxYWJmMGZiZDRlOGM4ZDYzIn0.y6nzB_bOmtwFFnEBTJjCP9-4WwtTiUp9qe3LvaWH788",
    "token_type": "bearer",
    "customerId": 5,
    "expires_in": "30 minutes"
}

@apiErrorExample Invalid data (code has expired):
HTTP/1.1 422 Error
{
    "message": "The given data was invalid.",
    "errors": {
        "code": [
            "Code has expired"
        ]
    }
}

@apiErrorExample Invalid data (code length is not 6 or has string):
HTTP/1.1 422 Error
{
    "message": "The given data was invalid.",
    "errors": {
        "code": [
            "The code must be an integer"
            "Invalid code"
        ]
    }
}
###

###
@api {get} /api/customer/customer-type Get list type customers
@apiName Get list type customers
@apiDescription Get list type customers
@apiGroup Auth
@apiVersion 0.1.0


@apiSuccessExample Success-Response:
HTTP/1.1 200 OK
{
    "data": [
        {
            "id": 1,
            "name": "service provider"
        }
    ]
}
###

###
@api {put} /api/customer/provide-info-customer Provide info customer
@apiName Provide info customer
@apiDescription Sign up customer
@apiGroup Auth
@apiVersion 0.1.0

@apiParam {string} first_name
@apiParam {string} last_name
@apiParam {Integer} phone
@apiParam {string} email
@apiParam {string} address
@apiParam {Integer} lat
@apiParam {Integer} lon

@apiSuccessExample Success-Response:
HTTP/1.1 200 OK
{
    "message": "Successfully logged up"
}
###

###
@api {put} /api/customer/provide-info-service-provider Provide info service provider
@apiName Provide info service provider
@apiDescription Sign up customer service provider type
@apiGroup Auth
@apiVersion 0.1.0

@apiParam {string} first_name
@apiParam {string} last_name
@apiParam {Integer} phone
@apiParam {string} email
@apiParam {string} address
@apiParam {Integer} supplier_type
@apiParam {Integer} service_type

@apiSuccessExample Success-Response:
HTTP/1.1 200 OK
{
    "message": "Successfully logged up"
}
###

###
@api {get} /api/customer/get-profile Get profile customer
@apiName Get profile customer
@apiDescription Get profile customer.
@apiGroup Auth
@apiVersion 0.1.0

@apiHeader {String} Authorization Bearer token

@apiSuccessExample Success-Response:
HTTP/1.1 200 OK
{
    "id": 1,
    "first_name": John,
    "last_name":  Doe,
    "email":  johndoe@gmail.com,
    "phone": 380973614352
    "address":  Oak Ave, 5,
    "latitude": 28.486182918363664
    "longitude": 49.23888621213321
}

@apiErrorExample Invalid data (phone is null or must be integer):
HTTP/1.1 422 Error
{
    "message": "The given data was invalid.",
    "errors": {
        "phone": [
	     "The phone must be an integer",
		 "The phone field is required"
        ]
    }
###

###
@api {put} /api/customer/edit-profile Edit profile customer
@apiName Edit profile customer
@apiDescription Edit profile customer.
@apiGroup Auth
@apiVersion 0.1.0

@apiParam {string} first_name
@apiParam {string} last_name
@apiParam {Integer} phone
@apiParam {Integer} email
@apiParam {Integer} address
@apiParam {Integer} lat
@apiParam {Integer} lon
@apiHeader {String} Authorization Bearer token

@apiSuccessExample Success-Response:
HTTP/1.1 200 OK
{
    "customerId": 8,
    "first_name": John,
    "last_name":  Doe,
    "email":  johndoe@gmail.com,
    "phone": 380973614352
    "address":  Oak Ave, 5,
    "latitude": 28.486182918363664
    "longitude": 49.23888621213321
}

@apiErrorExample Invalid data (phone is null or must be integer):
HTTP/1.1 422 Error
{

    "message": "The given data was invalid.",
    "errors": {
        "phone": [
	     "The phone must be an integer",
		 "The phone field is required"
        ]
    }
}
###

###
@api {put} /api/customer/create-order The customer sends the order
@apiName The customer sends the order
@apiDescription The customer sends the order
@apiGroup Auth
@apiVersion 0.1.0

@apiHeader {String} Authorization Bearer token

@apiSuccessExample Success-Response:
HTTP/1.1 200 OK
{
    "customerId": 1,
    "status": true
}
###

###
@api {put} /api/customer/push-notifications Receive push notifications
@apiName Receive push notifications
@apiDescription Receive push notifications
@apiGroup Auth
@apiVersion 0.1.0

@apiParam {bool} push Required
@apiHeader {String} Authorization Bearer token

@apiSuccessExample Success-Response:
HTTP/1.1 200 OK
{
    "customerId": 8,
    "status": true
}
###

###
@api {get} /api/customer/support Get support
@apiName Get support
@apiDescription Get support
@apiGroup Auth
@apiVersion 0.1.0

@apiHeader {String} Authorization Bearer token

@apiSuccessExample Success-Response:
HTTP/1.1 200 OK
{
    "whatsapp": "https://api.whatsapp.com/send/?phone=380951101619&text&app_absent=0"
}
###

###
@api {get} /api/customer/check-drivers-around Check drivers around
@apiName Check drivers around
@apiDescription Check drivers around
@apiGroup Auth
@apiVersion 0.1.0

@apiHeader {String} Authorization Bearer token

@apiSuccessExample Success-Response:
HTTP/1.1 200 OK
{
    "driver_id": 8,
    "first_name": "John",
    "last_name": "Doy",
    "phone": 1221124121
    "remoteness": 4
    "lonDriver": "28.486182918363664",
    "latDriver": "49.23888621213321",
    "customer_id": 3
}
###

###
@api {post} /api/customer/refresh-token Refresh customer token
@apiName Refresh customer token
@apiDescription Refresh customer token
@apiGroup Auth
@apiVersion 0.1.0

@apiHeader {String} Authorization Bearer token

@apiSuccessExample Success-Response:
HTTP/1.1 200 OK

@apiSuccessExample Success-Response:
HTTP/1.1 200 OK
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvYXBpXC9jdXN0b21lclwvcmVmcmVzaC10b2tlbiIsImlhdCI6MTYwODkwNTg0OCwiZXhwIjoxNjE2Nzg5ODY2LCJuYmYiOjE2MDg5MDU4NjYsImp0aSI6IjRCbTNnOGNGS0ZIM1JyeWQiLCJzdWIiOjEsInBydiI6IjFkMGEwMjBhY2Y1YzRiNmM0OTc5ODlkZjFhYmYwZmJkNGU4YzhkNjMifQ.Lcih9OYTQ5c0dxhpiWgOXrcfp1_rE9CZUWGdklJOhhE",
    "token_type": "bearer",
    "customerId": 1,
    "expires_in": "30 minutes"
}
###

###
@api {post} /api/customer/devices Push-token to Firebase
@apiName Push-token to Firebase
@apiDescription Push-token to Firebase
@apiGroup Auth

@apiHeader {String} Authorization Bearer token
@apiParam {String} deviceToken
@apiParam {String} type

HTTP/1.1 200 OK
{
    "success": true
}

HTTP/1.1 401 Error
{
    "message": "Unauthenticated."
}
###

###
@api {post} /api/customer/logout Logout from application
@apiName Logout from application
@apiDescription Logout from application
@apiGroup Auth

@apiHeader {String} Authorization Bearer token
@apiParam {String} deviceToken

HTTP/1.1 200 OK
{
    "message": "Successfully logged out"
}
###
