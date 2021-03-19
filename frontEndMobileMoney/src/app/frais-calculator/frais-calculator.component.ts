import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { ModalController } from '@ionic/angular';
import { CalculatorModalComponent } from '../calculator-modal/calculator-modal.component';
import { TransactionService } from '../services/transactionService/transaction.service';

@Component({
  selector: 'app-frais-calculator',
  templateUrl: './frais-calculator.component.html',
  styleUrls: ['./frais-calculator.component.scss'],
})
export class FraisCalculatorComponent implements OnInit {

  calculatorForm : FormGroup;
  montantFormControl = new FormControl('', [Validators.required, Validators.pattern(/(^[0-9])/)]);

  frais : number;

  constructor(private router : Router, private formBuilder: FormBuilder, private transactionService : TransactionService, private modalCtrl : ModalController) { }

  ngOnInit() {
    this.calculatorForm  =  this.formBuilder.group({
      montant : this.montantFormControl
    });
  }

  getBackHome(){
    return this.router.navigate(['/acceuil']);
  }

  async showModal(){
      const modal = await this.modalCtrl.create({
        component : CalculatorModalComponent,
        componentProps : {
          data : [this.calculatorForm.value]
        },
        cssClass : 'calculatorModal-component-css'
      })
      await modal.present();
  }

}
