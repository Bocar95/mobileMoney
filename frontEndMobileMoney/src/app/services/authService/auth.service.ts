import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Storage } from '@ionic/storage';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  private host = environment.host;

  constructor(private http : HttpClient, private storage: Storage) { }

  loginUser(user){
    return this.http.post<any>(`${this.host}/api/login_check`, user);
  }

  loggedIn(){
    return this.storage.get('token');
  }

  getToken(){
    return this.storage.get('token');
  }
  
}
