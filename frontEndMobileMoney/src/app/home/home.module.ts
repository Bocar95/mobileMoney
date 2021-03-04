import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { IonicModule } from '@ionic/angular';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import { HomePageRoutingModule } from './home-routing.module';

import { HomePage } from './home.page';
import { ConnexionPageComponent } from './../connexion-page/connexion-page.component';
import { AcceuilComponent } from '../acceuil/acceuil.component';
import { DepotFormulaireComponent } from '../depot-formulaire/depot-formulaire.component';

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
    DepotFormulaireComponent
  ]
})
export class HomePageModule {}
