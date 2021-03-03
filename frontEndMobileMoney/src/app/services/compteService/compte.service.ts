import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class CompteService {

  compteUrl = "http://127.0.0.1:8000/api/agence";

  constructor(private http: HttpClient) { }

  getCompteByAgenceId(id){
    return this.http.get(`${this.compteUrl}/${id}/compte`);
  }
}
