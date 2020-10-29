import { BaseComponent } from '@app/_components/base-component';
import { BrandsService } from '@app/_services/brands/brands.service';
import { BreakpointObserver } from '@angular/cdk/layout';
import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-brands',
  templateUrl: './brands.component.html',
  styleUrls: ['./brands.component.scss']
})
export class BrandsComponent extends BaseComponent {

  constructor(
    protected breakpointObserver: BreakpointObserver,
    public service: BrandsService
  ) {
    super(breakpointObserver, service);
  }
}
