import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AcceuilComponent } from '../acceuil/acceuil.component';
import { BeneficiareFormulaireComponent } from '../formulaires/depot-formulaire/beneficiare-formulaire/beneficiare-formulaire.component';
import { DepotFormulaireComponent } from '../formulaires/depot-formulaire/depot-formulaire.component';
import { EmetteurFormulaireComponent } from '../formulaires/depot-formulaire/emetteur-formulaire/emetteur-formulaire.component';
import { AuthGuard } from '../services/authGuardService/auth.guard';
import { HomePage } from './home.page';

const routes: Routes = [
  { path: '', component: HomePage },
  { path : 'acceuil', component: AcceuilComponent, canActivate: [AuthGuard] },
  { path : 'depot', component: DepotFormulaireComponent, canActivate: [AuthGuard],
      children:[
        { path: 'emetteur', component: EmetteurFormulaireComponent },
        { path: 'beneficiaire', component: BeneficiareFormulaireComponent }
      ]
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class HomePageRoutingModule {}
