import { Component, Input, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { Router } from '@angular/router';
import { ModalController, NavController } from '@ionic/angular';
import { TransactionService } from '../services/transactionService/transaction.service';

@Component({
  selector: 'app-retrait-modal',
  templateUrl: './retrait-modal.component.html',
  styleUrls: ['./retrait-modal.component.scss'],
})
export class RetraitModalComponent implements OnInit {

  @Input() data:any;

  confirmRetrait : FormGroup;

  nomBeneficiaire : string; 
  telephone : number;
  montant : number;
  nomEmetteur : string;
  telephoneEmetteur : number;

  constructor(private modalCtrl : ModalController, private formBuilder : FormBuilder, private transactionService : TransactionService, private navCtrl : NavController) { }

  ngOnInit() {
    this.confirmRetrait = this.formBuilder.group({
      codeTrans : this.data[0]["codeTrans"],
      numCni : this.data[0]["numCni"],
      telephone : this.data[0]["telephone"]
    });
    this.nomBeneficiaire = this.data[0]["nomBeneficiaire"]; 
    this.telephone = this.data[0]["telephone"];
    this.montant = this.data[0]["montant"];
    this.nomEmetteur = this.data[1];
    this.telephoneEmetteur = this.data[2];
  }

  async closeModal(){
    await this.modalCtrl.dismiss();
  }

  // reloadComponent() {
  //   let currentUrl = this.router.url;
  //   this.router.routeReuseStrategy.shouldReuseRoute = () => false;
  //   this.router.onSameUrlNavigation = 'reload';
  //   return this.router.navigate(['/acceuil']);
  // }

  retraitTrans(){
    return this.transactionService.retrait(this.confirmRetrait.value).subscribe(
      res => {
        console.log(res)
      }
    ), this.closeModal(), this.navCtrl.pop();
  }

}
