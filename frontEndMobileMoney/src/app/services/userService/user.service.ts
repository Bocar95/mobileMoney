import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Subject } from 'rxjs';
import {map, tap} from 'rxjs/operators';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class UserService {

  userUrl = "http://127.0.0.1:8000/api/user";
  private host = environment.host;


  private  _refreshNeeded$ = new Subject<void>() ;

  refreshNeeded$() {
    return this._refreshNeeded$ ;
  }

  constructor(private http: HttpClient) { }

  getCompteByUserUsername(username){
    return this.http.get(`${this.userUrl}/${username}/compte`);
  }

  getUserById(id : number){
    return this.http.get(`${this.host}/api/user/${id}`);
  }

  getUserByUsername(username : number){
    return this.http.get(`${this.host}/api/user/${username}`);
  }
}
