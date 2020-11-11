import { RemoveDialogComponent } from './helpers/remove-dialog/remove-dialog.component';
import { ChildCreateFormBaseComponent } from '@app/_components/child-create-form-base-component';
import { MatDialog } from '@angular/material/dialog';
import { IService } from '@app/_services/iservice';
import { Subscription } from 'rxjs';
import { OnInit, OnDestroy, Input, TemplateRef, Component } from '@angular/core';
import { ComponentCreateRegistryService } from '@app/_services/component-create-registry.service';

export class ChildBaseComponent implements OnInit, OnDestroy {
  private serviceEndUpdateSubscription: Subscription;
  @Input() service: IService;
  @Input() createComponent: string;
  constructor(
    public dialog: MatDialog,
    private compCreateRegistry: ComponentCreateRegistryService) { }

  public ngOnInit(): void {
    this.serviceEndUpdateSubscription = this.service.endUpdate.subscribe(data => {
      if (data === true) {
        this.endUpdate();
        this.dialog.closeAll();
      }
    });
    this.init();
  }

  public init(): void { }
  public endUpdate() { }

  ngOnDestroy(): void {
    if (this.serviceEndUpdateSubscription) { this.serviceEndUpdateSubscription.unsubscribe(); }
  }

  openCreateDialog(event): void {
    event.stopPropagation();
    const dialogRef = this.dialog.open(this.compCreateRegistry.getComponentByName(this.createComponent));
    (dialogRef.componentInstance as unknown as ChildCreateFormBaseComponent).create();
    dialogRef.afterClosed().subscribe(result => {
      if (result) {
      }
    });
  }

  openUpdateDialog(event, element: any): void {
    event.stopPropagation();
    const dialogRef = this.dialog.open(this.compCreateRegistry.getComponentByName(this.createComponent));
    dialogRef.afterClosed().subscribe(result => {
      if (result) {
      }
    });
    (dialogRef.componentInstance as unknown as ChildCreateFormBaseComponent).update(element);
  }

  openDeleteDialog(event, element: any, title: string): void {
    event.stopPropagation();
    const dialogRef = this.dialog.open(RemoveDialogComponent);
    (dialogRef.componentInstance as RemoveDialogComponent).title = title;
    dialogRef.afterClosed().subscribe(result => {
      if (result && result.data === true) {
        this.service.update(undefined, element, null);
      }
    });
  }
}
