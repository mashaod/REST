new Vue({
    el: ".register-page",
    data: {
        login: '',
        password: '',
        errMessage: '',
        successMessage: '',
        success: false,
        responseAjax: {},
    },
    created () {
    },
    methods: {
        ajaxAddUser(params){
            var self = this
                var request = new XMLHttpRequest()
                request.responseType = 'text'
                request.onreadystatechange = function(){
                    if(request.readyState == 4 && (request.status == 200 || request.status == 201 || request.status == 202)){
                        self.success = 'true';
                    }else if(request.readyState == 4 && (request.status == 404)){
                        self.login = ''
                        self.password = ''
                        self.errMessage = "login reserved"
                    }
                }
                request.open('POST', 'api/users/')
                request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
                request.send(params)
        },
        checkForm() {
            if (this.checkLogin() && this.checkPassword()){
                    this.errMessageLogIn = ""
                    this.successMessage = "Thank you for registration";
                    var registerParams = 'login=' + this.login + '&password=' + this.password;
                    this.ajaxAddUser(registerParams) 

            }else{
                return false
            }
        },
        checkLogin(){
            if (this.login.length > 3 ){
                this.errMessage = ""
                    return true
            }else{
                this.errMessage = "Small login"
                return false;    
            } 
        },
        checkPassword(){
            if (this.password.length > 5) {
                this.errMessage = ""
                    return true
            }else{
                this.errMessage = "Password must be more than 5 symbols"
                return false;    
            }      
        }
    }
})
