import { CompteService } from './services/compteService/compte.service';
import { TokenInterceptorService } from './services/tokenInterceptorService/token-interceptor.service';
import { AuthService } from './services/authService/auth.service';
import { NgModule } from '@angular/core';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { BrowserModule } from '@angular/platform-browser';
import { RouteReuseStrategy } from '@angular/router';
import { IonicModule, IonicRouteStrategy } from '@ionic/angular';
import { IonicStorageModule } from '@ionic/storage';

import { AppRoutingModule } from './app-routing.module';
import { HttpClientModule, HTTP_INTERCEPTORS } from '@angular/common/http';

import { AppComponent } from './app.component';
import { AuthGuard } from './services/authGuardService/auth.guard';
import { OrderByPipe } from './order-by.pipe';
import { ListTransactionsComponent } from './list-transactions/list-transactions.component';

@NgModule({
  declarations: [
    AppComponent,
    ListTransactionsComponent,
    OrderByPipe
  ],
  entryComponents: [],
  imports: [
    BrowserModule,
    FormsModule,
    ReactiveFormsModule,
    IonicModule.forRoot(),
    AppRoutingModule,
    IonicStorageModule.forRoot(),
    HttpClientModule
  ],
  providers: [
      AuthService,
      AuthGuard,
      CompteService,
      {
        provide: HTTP_INTERCEPTORS, useClass: TokenInterceptorService, multi:true
      },
    { 
      provide: RouteReuseStrategy,
      useClass: IonicRouteStrategy
    }
  ],
  bootstrap: [AppComponent],
})
export class AppModule {}
