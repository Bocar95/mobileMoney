import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Storage } from '@ionic/storage';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  private loginCheckUrl = "http://127.0.0.1:8000/api/login_check";

  constructor(private http : HttpClient, private storage: Storage) { }

  loginUser(user){
    return this.http.post<any>(this.loginCheckUrl, user);
  }

  loggedIn(){
    return this.storage.get('token');
  }

  getToken(){
    return this.storage.get('token');
  }
  
}
