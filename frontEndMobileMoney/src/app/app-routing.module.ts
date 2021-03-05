import { NgModule } from '@angular/core';
import { PreloadAllModules, RouterModule, Routes } from '@angular/router';
import { AcceuilComponent } from './acceuil/acceuil.component';
import { ConnexionPageComponent } from './connexion-page/connexion-page.component';
import { BeneficiareFormulaireComponent } from './formulaires/depot-formulaire/beneficiare-formulaire/beneficiare-formulaire.component';
import { DepotFormulaireComponent } from './formulaires/depot-formulaire/depot-formulaire.component';
import { EmetteurFormulaireComponent } from './formulaires/depot-formulaire/emetteur-formulaire/emetteur-formulaire.component';
import { AuthGuard } from './services/authGuardService/auth.guard';

const routes: Routes = [
  { path: 'home', loadChildren: () => import('./home/home.module').then( m => m.HomePageModule) },
  { path: '', redirectTo: 'home', pathMatch: 'full' },
  { path: 'connexion', component: ConnexionPageComponent },
  { path: 'acceuil', component: AcceuilComponent, canActivate: [AuthGuard] },
  { path : 'depot', component: DepotFormulaireComponent, canActivate: [AuthGuard],
      children:[
        { path: 'emetteur', component: EmetteurFormulaireComponent },
        { path: 'beneficiaire', component: BeneficiareFormulaireComponent }
      ]
  }
];

@NgModule({
  imports: [
    RouterModule.forRoot(routes, { preloadingStrategy: PreloadAllModules })
  ],
  exports: [RouterModule]
})
export class AppRoutingModule { }
