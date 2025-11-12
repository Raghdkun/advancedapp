import 'package:dartz/dartz.dart';
import 'package:injectable/injectable.dart';

import '../../../../core/error/failures.dart';
import '../../../../core/usecases/usecase.dart';
import '../entities/counter.dart';
import '../repositories/counter_repository.dart';

@injectable
class IncrementCounter implements UseCase<Counter, NoParams> {
  final CounterRepository repository;

  IncrementCounter(this.repository);

  @override
  Future<Either<Failure, Counter>> call(NoParams params) async {
    return await repository.incrementCounter();
  }
}
