import { ComponentCreateRegistryService } from '@app/_services/component-create-registry.service';
import { ChildBaseComponent } from '@app/_components/child-base-component';
import { MatDialog } from '@angular/material/dialog';
import { Component, AfterViewInit } from '@angular/core';

@Component({
  selector: 'app-categories-mobile',
  templateUrl: './categories-mobile.component.html',
  styleUrls: ['./categories-mobile.component.scss']
})
export class CategoriesMobileComponent extends ChildBaseComponent implements AfterViewInit {
  constructor(public dialog: MatDialog, private createRegistry: ComponentCreateRegistryService) {
    super(dialog, createRegistry);
  }

  ngAfterViewInit(): void {
  }

  public endUpdate() {
  }

  public init() {
  }

}
