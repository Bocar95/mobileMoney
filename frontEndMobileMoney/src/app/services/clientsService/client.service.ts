import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class ClientService {

  private host = environment.host;

  constructor(private http : HttpClient) { }

  getClientByCni(nci:number){
    return this.http.get(`${this.host}/api/user/client/${nci}`);
  }
}
