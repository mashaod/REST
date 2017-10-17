new Vue({
    el: ".cars",
    data: {
    auth: false,
    ordersBlock: false,
    carSelected: false,
    login: '',
    password: '',
    id_user: '',
    id_car: '-',
    brand: '-',
    year: '1',
    engine: '-',
    color: '-',
    speed: '-',
    price: '-',
    payment: 'card',
    orderStatus: '-',
    errMessageLogIn: '',
    messageCreateOrder: '',
    errMessageChangeOrder: '',
    successMessage: false,
    carList: {},
    selectedCar: {},
    userOrders: {},
    statusList: [
        {
            value: 'hold',
            title: 'hold'
        },
        {
            value: 'delivery',
            title: 'delivery'
        },
        {
            value: 'done',
            title: 'done'
        }     
    ],
    options: {
        brands: [
        {
            value: 'Bugatti',
            title: 'Bugatti'
        },
        {
            value: 'Rolls-Royce',
            title: 'Rolls-Royce'
        },
        {
            value: 'Jaguar',
            title: 'Jaguar'
        }
        ],
            years: [
            {
                value: '2011',
                title: '> 2011'
            },
            {
                value: '2010',
                title: '> 2010'
            },
            {
                value: '2009',
                title: '> 2009'
            }
        ],
            engines: [
            {
                value: '6000',
                title: '> 6000'
            },
            {
                value: '4000',
                title: '> 4000'
            },
            {
                value: '2000',
                title: '> 2000'
            }
        ],
            colors: [
            {
                value: 'white',
                title: 'white'
            },
            {
                value: 'black',
                title: 'black'
            },
            {
                value: 'yellow',
                title: 'yellow'
            }
        ],
            speeds: [
            {
                value: '300',
                title: '> 300'
            },
            {
                value: '250',
                title: '> 250'
            },
            {
                value: '200',
                title: '> 200'
            }
        ],
            prices: [
            {
                value: '1500000',
                title: '> 1 500 000'
            },
            {
                value: '900000',
                title: '> 900 000'
            },
            {
                value: '100000',
                title: '> 100 000'
            }
        ],
    }
    },
    created () {
        this.checkUser(),
        this.filteredCars(),
        this.year = '-'
    },
    methods: {
        ajaxGetCars(params='', callback){
            var self = this

                var request = new XMLHttpRequest()
                request.responseType = 'text'

                request.onreadystatechange = function(){
                    if(request.readyState == 4 && (request.status == 200 || request.status == 201 || request.status == 202))
                        callback(JSON.parse(request.responseText))
                }

                request.open('GET', 'api/cars/' + params)
                request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
                request.send()
        },
        ajaxLogIn(params){
            var self = this

            var request = new XMLHttpRequest()
            request.responseType = 'text'

            request.onreadystatechange = function(){
            if(request.readyState == 4 && (request.status == 200 || request.status == 201 || request.status == 202)){
                var data = JSON.parse(request.responseText)
                    localStorage.setItem('hash', JSON.stringify(data.hash))
                    localStorage.setItem('id', JSON.stringify(data.id_user))
                    self.checkUser()
                }
                else if(request.readyState == 4 && request.status == 404)
                    self.errMessageLogIn = 'Incorrect login or password'
            }
            request.open('PUT', 'api/users/' + params)
            request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
            request.send()
        },
        ajaxCheckUser(params, callback){
            var self = this

            var request = new XMLHttpRequest()
            request.responseType = 'text'

            request.onreadystatechange = function(){
                if(request.readyState == 4 && (request.status == 200 || request.status == 201 || request.status == 202)){
                    self.auth = (request.responseText == 'true')?true:false
                    callback(self.auth)
                }
            }

            request.open('GET', 'api/users/' + params, true)
            request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
            request.send()
        },
        ajaxCreateOrder(params){
            var self = this

            var request = new XMLHttpRequest()
            request.responseType = 'text'

            request.onreadystatechange = function(){

                if(request.readyState == 4 && (request.status == 200 || request.status == 201 || request.status == 202)){
                    self.messageCreateOrder = 'Exelent!'
                }else{
                    self.messageCreateOrder = 'Incorrect operation'
                }
            }

            request.open('POST', 'api/orders/')
            request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
            request.send(params)

        },
        ajaxGetOrders(params, callback){
            var self = this
            
            var request = new XMLHttpRequest()
            request.responseType = 'text'

            request.onreadystatechange = function(){
                if(request.readyState == 4 && (request.status == 200 || request.status == 201 || request.status == 202)){
                    var listOrders = JSON.parse(request.responseText)
                    callback(listOrders)
                }else{
                    self.userOrders = {} 
                }
            }
            request.open('GET', 'api/orders/' + params)
            request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
            request.send()
        },
        ajaxChangeOrder(params, callback){
            var self = this

            var request = new XMLHttpRequest()
            request.responseType = 'text'

            request.onreadystatechange = function(){
                if(request.readyState == 4 && (request.status == 200 || request.status == 201 || request.status == 202))
                    var response = JSON.parse(request.responseText)
            }
               
            request.open('PUT', 'api/orders/' + params)
            request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
            request.send()
        },
        openCar(id_car){
            if(id_car && id_car != '')
            {
                this.messageCreateOrder = ''
                this.carSelected = true
                var self = this
                this.ajaxGetCars(id_car, function(car) {
                    self.selectedCar=(car && car != {})?car[0]:{}            
                })
            }
        },
        filteredCars(){
            if(this.year != '-')
            {
                this.carSelected = false 
                var getParams = '-/' + this.brand + '/-/' + this.year + '/' + this.engine + '/' + this.color + '/' + this.speed + '/' + this.price
                var self = this
                this.ajaxGetCars(getParams, function(cars) {
                    self.carList=(cars && cars != {})?cars:{}            
                })
            }
        },
        checkLogIn() {
            if (this.login != '' && this.password != ''){ 
                var logInParams = 'login=' + this.login + '&password=' + this.password
                this.ajaxLogIn(logInParams)

            }else{
                this.errMessageLogIn = "This values is required"
                    return false
            }
        },
        checkUser(){
            var hash = JSON.parse(localStorage.getItem('hash'))
            var id_user = JSON.parse(localStorage.getItem('id'))

            if(hash && id_user){
               var checkUserParams = id_user + '/' + hash
                
               var self = this
               this.ajaxCheckUser(checkUserParams, function(auth) {
                    auth?self.getDataUser(id_user):''
                })           
            }else{
                this.auth = false
                this.login = ''
                this.password = ''
            }
        },
        getDataUser(id_user){
            if(id_user && id_user != '')
            {
                var self = this
                this.id_user = id_user

                this.ajaxGetOrders(id_user, function(listOrders) {

                    var orders=[]
                    listOrders.forEach(function(item, i, arr) {
                        var id_car = item.id_car
                        var options = {}
                        options.payment = item.payment
                        options.stat = item.status
                        options.id_order = item.id_orders

                        self.ajaxGetCars(id_car, function(car) {
                            orders[i]=Object.assign(car[0],options)      
                        })              
                    }) 
                    self.userOrders=orders
                })
            } 
        },
        logout(){ 
           localStorage.removeItem('hash')
           localStorage.removeItem('id')
           this.ordersBlock = false 
           this.checkUser()

        },
        createOrder(){
            this.checkUser()
            var orderParams = 'id_user=' + this.id_user + '&id_car=' + this.selectedCar.id_car + '&payment=' + this.payment
            this.ajaxCreateOrder(orderParams) 
        },
        changeStatusOrder(id, status){
            if(id && status){
                var self = this
                this.errMessageChangeOrder=''    
                var orderStatusParams = 'id_order=' + id + '&status=' + status
                this.ajaxChangeOrder(orderStatusParams, function() {
                    self.getDataUser(self.id_user)
                })  
            } 
        }
    }
})
