import { NgModule } from '@angular/core';
import { PreloadAllModules, RouterModule, Routes } from '@angular/router';
import { AcceuilComponent } from './acceuil/acceuil.component';
import { CommissionsComponent } from './commissions/commissions.component';
import { CompteTransactionsComponent } from './compte-transactions/compte-transactions.component';
import { ConnexionPageComponent } from './connexion-page/connexion-page.component';
import { DepotFormulaireComponent } from './depot-formulaire/depot-formulaire.component';
import { FraisCalculatorComponent } from './frais-calculator/frais-calculator.component';
import { ListTransactionsComponent } from './list-transactions/list-transactions.component';
import { RefreshComponent } from './refresh/refresh.component';
import { RetraitFormulaireComponent } from './retrait-formulaire/retrait-formulaire.component';
import { AuthGuard } from './services/authGuardService/auth.guard';

const routes: Routes = [
  { path: 'home', loadChildren: () => import('./home/home.module').then( m => m.HomePageModule) },
  { path: '', redirectTo: 'home', pathMatch: 'full' },
  { path: 'connexion', component: ConnexionPageComponent },
  { path: 'acceuil', component: AcceuilComponent, canActivate: [AuthGuard] },
  { path : 'depot', component: DepotFormulaireComponent, canActivate: [AuthGuard] },
  { path : 'retrait', component: RetraitFormulaireComponent, canActivate: [AuthGuard] },
  { path : 'refresh', component: RefreshComponent, canActivate: [AuthGuard] },
  { path : 'myTransactions', component : ListTransactionsComponent, canActivate : [AuthGuard] },
  { path : 'compteTransactions', component : CompteTransactionsComponent, canActivate : [AuthGuard] },
  { path : 'fraisCalculator', component : FraisCalculatorComponent, canActivate : [AuthGuard] },
  { path : 'commissions', component : CommissionsComponent, canActivate : [AuthGuard] }

];

@NgModule({
  imports: [
    RouterModule.forRoot(routes, { preloadingStrategy: PreloadAllModules })
  ],
  exports: [RouterModule]
})
export class AppRoutingModule { }
