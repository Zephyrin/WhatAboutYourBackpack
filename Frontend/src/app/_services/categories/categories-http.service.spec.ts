import { TestBed } from '@angular/core/testing';

import { CategoriesHttpService } from './categories-http.service';

describe('CategoriesHttpService', () => {
  let service: CategoriesHttpService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(CategoriesHttpService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
