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

  frais : number = 0;
  montant : number;

  constructor(private router : Router, private formBuilder: FormBuilder, private transactionService : TransactionService, private modalCtrl : ModalController) { }

  ngOnInit() {
    this.calculatorForm  =  this.formBuilder.group({
      montant : this.montantFormControl
    });
  }

  calculator(){
    return this.transactionService.getFrais(+this.montantFormControl.value).subscribe(
      (fraisData : number) => {
        this.frais = fraisData
        // this.montant = this.data["montant"],
      }
    );
  }

  getBackHome(){
    return this.router.navigate(['/acceuil']);
  }

}
