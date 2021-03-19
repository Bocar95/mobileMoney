import { Component, Input, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { Router } from '@angular/router';
import { ModalController } from '@ionic/angular';
import { TransactionService } from '../services/transactionService/transaction.service';

@Component({
  selector: 'app-calculator-modal',
  templateUrl: './calculator-modal.component.html',
  styleUrls: ['./calculator-modal.component.scss'],
})
export class CalculatorModalComponent implements OnInit {

  @Input() data : any;

  fraisForm : FormGroup;

  montant;
  frais;

  constructor(private router : Router, private modalCtrl : ModalController, private formBuilder : FormBuilder, private transactionService : TransactionService) { }

  ngOnInit() {
    this.fraisForm  =  this.formBuilder.group({
      montant : this.data["montant"]
    });
    this.calculer();
  }

  async closeModal(){
    this.router.navigate(['/acceuil']);
    await this.modalCtrl.dismiss();
  }


  calculer(){
    return this.transactionService.getFrais(this.data["montant"]).subscribe(
      (fraisData) => {
        this.frais = fraisData,
        this.montant = this.data["montant"],
        console.log(fraisData)
      }
    );
  }

}
