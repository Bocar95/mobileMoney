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

  constructor(private modalCtrl : ModalController, private formBuilder : FormBuilder, private transactionService : TransactionService, private navCtrl : NavController, private router : Router) { }

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
    this.router.navigate(['/retrait']);
    await this.modalCtrl.dismiss();
  }

  retraitTrans(){
    return this.transactionService.retrait(this.confirmRetrait.value).subscribe(
      res => {
        console.log(res)
      }
    ), this.closeModal(),this.router.navigate(['/acceuil']);
  }

}
