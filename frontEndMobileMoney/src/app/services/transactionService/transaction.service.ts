import { environment } from './../../../environments/environment';
import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';
import { Transaction } from 'src/app/models/transaction';
import { NgForm } from '@angular/forms';

@Injectable({
  providedIn: 'root'
})
export class TransactionService {

  private host = environment.host;

  constructor(private http : HttpClient) { }

  addDepot(data : NgForm) : Observable<Transaction>{
    return this.http.post<Transaction>(`${this.host}/api/user/transactions`, data);
  }

  getFrais(montant:number){
    return this.http.get(`${this.host}/api/user/frais/${montant}`);
  }

  getTransactionByCode(code){
    return this.http.get(`${this.host}/api/user/transaction/${code}`)
  }

  retrait(data){
    return this.http.put(`${this.host}/api/user/transactions/retrait`, data);
  }

  fusion(id){
    return of([
      {type:"depot",data: this.http.get(`${this.host}/api/user/${id}/depotTransactions`)},
      {type:"retrait",data: this.http.get(`${this.host}/api/user/${id}/retraitTransactions`)}
    ]);
  }

  getTransactionsByCompte(id){
    return of([
      {type:"depot",data: this.http.get(`${this.host}/api/admin/compte/${id}/depotTransactions`)},
      {type:"retrait",data: this.http.get(`${this.host}/api/admin/compte/${id}/retraitTransactions`)}
    ]);
  }

  getCommissionByCompte(id){
    return of([
      {type:"depot",data: this.http.get(`${this.host}/api/admin/compte/${id}/depotComission`)},
      {type:"retrait",data: this.http.get(`${this.host}/api/admin/compte/${id}/retraitComission`)}
    ]);
  }

  getUserByUsername(username : number){
    return this.http.get(`${this.host}/api/user/${username}`);
  }

  getTotal (frais:number, montant: number){
    return this.http.get(`${this.host}/api/user/totalToGive/${frais}/${montant}`);
  }
  
}
