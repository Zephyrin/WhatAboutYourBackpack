import { TestBed } from '@angular/core/testing';

import { BrandsHttpService } from './brands-http.service';

describe('BrandsHttpService', () => {
  let service: BrandsHttpService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(BrandsHttpService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
