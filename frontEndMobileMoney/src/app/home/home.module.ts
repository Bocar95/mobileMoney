import { DepotModalComponent } from './../depot-modal/depot-modal.component';
import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { IonicModule } from '@ionic/angular';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import { HomePageRoutingModule } from './home-routing.module';


import { HomePage } from './home.page';
import { ConnexionPageComponent } from './../connexion-page/connexion-page.component';
import { AcceuilComponent } from '../acceuil/acceuil.component';
import { DepotFormulaireComponent } from '../depot-formulaire/depot-formulaire.component';
import { RetraitFormulaireComponent } from '../retrait-formulaire/retrait-formulaire.component';
import { CodeModalComponent } from '../code-modal/code-modal.component';
import { RetraitModalComponent } from '../retrait-modal/retrait-modal.component';
import { RefreshComponent } from '../refresh/refresh.component';
import { FraisCalculatorComponent } from '../frais-calculator/frais-calculator.component';
import { CalculatorModalComponent } from '../calculator-modal/calculator-modal.component';
import { CompteTransactionsComponent } from '../compte-transactions/compte-transactions.component';
import { CommissionsComponent } from '../commissions/commissions.component';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    ReactiveFormsModule,
    IonicModule,
    HomePageRoutingModule
  ],
  declarations: [
    HomePage,
    ConnexionPageComponent,
    AcceuilComponent,
    DepotFormulaireComponent,
    RetraitFormulaireComponent,
    DepotModalComponent,
    CodeModalComponent,
    RetraitModalComponent,
    RefreshComponent,
    FraisCalculatorComponent,
    CalculatorModalComponent,
    CompteTransactionsComponent,
    CommissionsComponent
  ]
})
export class HomePageModule {}
