import { BaseComponent } from '@app/_components/base-component';
import { CategoriesService } from '@app/_services/categories/categories.service';
import { BreakpointObserver } from '@angular/cdk/layout';
import { Component } from '@angular/core';

@Component({
  selector: 'app-categories',
  templateUrl: './categories.component.html',
  styleUrls: ['./categories.component.scss']
})
export class CategoriesComponent extends BaseComponent {

  constructor(
    protected breakpointObserver: BreakpointObserver,
    public service: CategoriesService) {
    super(breakpointObserver, service);
  }
}
